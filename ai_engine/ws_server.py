"""
Server WebSocket real-time untuk analisis squat.

Jalankan dengan:
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

    # Single-worker executor: inferensi Ultralytics YOLO belum terverifikasi
    # thread-safe untuk pemanggilan konkuren pada satu instance model yang
    # dipakai bersama, jadi tiap frame (dari koneksi manapun) diproses satu
    # per satu di sini, bukan paralel. Di-scope ke lifespan app instance ini
    # supaya startup/shutdown berulang (misalnya lintas test) tidak memakai
    # ulang executor yang sudah di-shutdown.
    app.state.inference_executor = ThreadPoolExecutor(max_workers=1)

    yield

    app.state.inference_executor.shutdown(wait=False)


app = FastAPI(lifespan=lifespan)


@app.get("/health")
def health():
    return {"status": "ok"}


async def _send_json_safely(websocket: WebSocket, payload: dict) -> None:
    """Mengirim pesan JSON tanpa membiarkan kegagalan serialisasi (misalnya
    dtype numpy nyasar yang tidak JSON-serializable) merusak koneksi.
    Ini persis kelas bug yang dulu diam-diam mematikan WebSocket
    di tengah sesi: TypeError yang tidak tertangkap di dalam send_json
    merambat keluar dari route handler, lalu server ASGI menutup socket -
    yang di sisi browser kelihatan seperti kamera freeze.
    """
    try:
        await websocket.send_json(payload)
    except TypeError:
        await websocket.send_json({"type": "no_pose", "annotated_frame": None})


def _encode_annotated_frame(detector: PoseDetector, results):
    """Menggambar overlay skeleton YOLO (apapun yang terdeteksi, terlepas
    dari confidence threshold aplikasi) dan meng-encode-nya sebagai JPEG
    base64 supaya browser bisa menampilkan visual yang sama seperti jendela
    cv2.imshow di versi desktop. Mengembalikan None kalau proses gagal.
    """
    try:
        annotated = detector.draw(results)
        if annotated is None:
            return None

        ok, buffer = cv2.imencode(".jpg", annotated, [cv2.IMWRITE_JPEG_QUALITY, 60])
        if not ok:
            return None

        return base64.b64encode(buffer.tobytes()).decode("ascii")
    except Exception:
        return None


def _process_frame(detector: PoseDetector, frame):
    """Menjalankan satu frame lewat detector. Mengembalikan dict berisi
    sudut lutut mentah (belum di-smoothing; None kalau pose tidak cukup
    yakin terdeteksi) dan frame beranotasi ter-encode base64. Dijalankan
    di thread pool single-worker karena ini yang melakukan inferensi YOLO.
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

                # Pesan kontrol "start" (atau apapun selain "stop") tidak
                # perlu aksi - sesi sudah ada sejak koneksi dibuka.
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

            # Pengaman kedua: kalau NaN/inf entah bagaimana lolos dari
            # guard di AngleCalculator, jangan sampai terkirim ke JSON -
            # Python akan encode NaN sebagai literal `NaN` yang bikin
            # JSON.parse browser error dan kamera kelihatan freeze.
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
