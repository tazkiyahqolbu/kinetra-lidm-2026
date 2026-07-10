"""
=====================================
KINETRA AI ENGINE
WEBSOCKET SERVER (real-time squat analysis)
=====================================

Run with:
    uvicorn ai_engine.ws_server:app --host 127.0.0.1 --port 8001
"""

import asyncio
import base64
import json
import math
from concurrent.futures import ThreadPoolExecutor
from contextlib import asynccontextmanager

import cv2
import numpy as np
from fastapi import FastAPI, WebSocket, WebSocketDisconnect

from ai_engine.pose_detector import PoseDetector
from ai_engine.angle import AngleCalculator
from ai_engine.session import SquatSession


@asynccontextmanager
async def lifespan(app: FastAPI):

    app.state.detector = PoseDetector()

    # Single-worker executor: Ultralytics YOLO inference isn't verified
    # thread-safe for concurrent calls against one shared model instance,
    # so every frame (from every connection) is processed one at a time
    # here rather than in parallel. Scoped to this app instance's
    # lifespan so repeated app startup/shutdown (e.g. across tests)
    # doesn't reuse an already-shutdown executor.
    app.state.inference_executor = ThreadPoolExecutor(max_workers=1)

    yield

    app.state.inference_executor.shutdown(wait=False)


app = FastAPI(lifespan=lifespan)


@app.get("/health")
def health():

    return {"status": "ok"}


async def _send_json_safely(websocket: WebSocket, payload: dict) -> None:
    """
    Sends a JSON message without letting a serialization failure (e.g. a
    stray numpy dtype that isn't JSON-serializable) crash the whole
    connection. This is exactly the bug class that used to silently kill
    the WebSocket mid-session: an uncaught TypeError inside send_json
    propagates out of the route handler, and the ASGI server closes the
    socket - which looks like a frozen camera to the browser.
    """

    try:

        await websocket.send_json(payload)

    except TypeError:

        await websocket.send_json({"type": "no_pose", "annotated_frame": None})


def _encode_annotated_frame(detector: PoseDetector, results):
    """
    Draws the YOLO skeleton overlay (whatever was detected, regardless of
    the app's own confidence threshold) and JPEG-encodes it as base64 so
    the browser can show the same visual the desktop cv2.imshow window
    used to show. Returns None if drawing/encoding fails for any reason.
    """

    try:

        annotated = detector.draw(results)

        if annotated is None:

            return None

        ok, buffer = cv2.imencode(
            ".jpg", annotated, [cv2.IMWRITE_JPEG_QUALITY, 60]
        )

        if not ok:

            return None

        return base64.b64encode(buffer.tobytes()).decode("ascii")

    except Exception:

        return None


def _process_frame(detector: PoseDetector, frame):
    """
    Runs one frame through the detector. Returns a dict with the raw
    (unsmoothed) knee angle (None if no confident pose was found) and the
    base64-encoded annotated frame (None if it couldn't be produced).
    Executed on the single-worker thread pool since this does the actual
    YOLO inference.
    """

    try:

        results = detector.detect(frame)

        annotated_frame = _encode_annotated_frame(detector, results)

        keypoints = detector.get_keypoints(results)

        confidence = detector.get_confidence(results)

        if not detector.has_required_landmarks(confidence):

            return {"raw_angle": None, "annotated_frame": annotated_frame}

        hip, knee, ankle = detector.get_right_leg(keypoints)

        raw_angle = AngleCalculator.calculate(hip, knee, ankle)

        return {"raw_angle": raw_angle, "annotated_frame": annotated_frame}

    except Exception:

        return {"raw_angle": None, "annotated_frame": None}


@app.websocket("/ws/squat")
async def squat_ws(websocket: WebSocket):

    await websocket.accept()

    detector: PoseDetector = websocket.app.state.detector

    executor = websocket.app.state.inference_executor

    session = SquatSession()

    loop = asyncio.get_event_loop()

    try:

        while True:

            message = await websocket.receive()

            if message.get("type") == "websocket.disconnect":

                break

            text = message.get("text")

            if text is not None:

                try:

                    payload = json.loads(text)

                except json.JSONDecodeError:

                    continue

                if payload.get("type") == "stop":

                    break

                # "start" (or any other control message) needs no action -
                # the session already exists from connection open.
                continue

            data = message.get("bytes")

            if data is None:

                continue

            buffer = np.frombuffer(data, dtype=np.uint8)

            frame = cv2.imdecode(buffer, cv2.IMREAD_COLOR)

            if frame is None:

                continue

            pose_data = await loop.run_in_executor(
                executor, _process_frame, detector, frame
            )

            raw_angle = pose_data["raw_angle"]

            # Defense in depth: a NaN/inf angle (from a degenerate frame
            # that somehow slips past AngleCalculator's own guard) must
            # never reach json.dumps - Python happily encodes NaN as the
            # literal `NaN`, which is not valid JSON and makes the
            # browser's JSON.parse throw, silently killing the capture
            # loop (looks exactly like a frozen camera).
            if raw_angle is None or not math.isfinite(raw_angle):

                await _send_json_safely(websocket, {
                    "type": "no_pose",
                    "annotated_frame": pose_data["annotated_frame"],
                })

                continue

            try:

                frame_result = session.process_angle(raw_angle)

            except Exception:

                await _send_json_safely(websocket, {
                    "type": "no_pose",
                    "annotated_frame": pose_data["annotated_frame"],
                })

                continue

            await _send_json_safely(websocket, {
                "type": "frame_result",
                "angle": frame_result["angle"],
                "state": frame_result["state"],
                "repetition": frame_result["repetition"],
                "event": frame_result["event"],
                "result": frame_result["result"],
                "annotated_frame": pose_data["annotated_frame"],
            })

    except WebSocketDisconnect:

        pass
