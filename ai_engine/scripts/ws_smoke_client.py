"""
=====================================
KINETRA AI ENGINE
WEBSOCKET SMOKE CLIENT
=====================================

Manual smoke test against a REAL uvicorn process (real YOLO model loaded),
using a local video file instead of a live camera. Proves the frame ->
inference -> JSON pipeline works before ever touching a browser.

Usage:
    uvicorn ai_engine.ws_server:app --host 127.0.0.1 --port 8001
    python -m ai_engine.scripts.ws_smoke_client path/to/squat_video.mp4
"""

import asyncio
import json
import sys

import cv2
import websockets

DEFAULT_WS_URL = "ws://127.0.0.1:8001/ws/squat"


async def stream_video(video_path, ws_url=DEFAULT_WS_URL):

    capture = cv2.VideoCapture(video_path)

    if not capture.isOpened():

        print(f"Could not open video: {video_path}")

        return

    async with websockets.connect(ws_url) as ws:

        await ws.send(json.dumps({"type": "start"}))

        frame_count = 0

        while True:

            ret, frame = capture.read()

            if not ret:

                break

            ok, buffer = cv2.imencode(".jpg", frame)

            if not ok:

                continue

            await ws.send(buffer.tobytes())

            message = json.loads(await ws.recv())

            frame_count += 1

            print(f"[frame {frame_count}] {message}")

        await ws.send(json.dumps({"type": "stop"}))

    capture.release()

    print(f"Done. Streamed {frame_count} frames.")


if __name__ == "__main__":

    if len(sys.argv) < 2:

        print("Usage: python -m ai_engine.scripts.ws_smoke_client <video_path> [ws_url]")

        sys.exit(1)

    video_arg = sys.argv[1]

    url_arg = sys.argv[2] if len(sys.argv) > 2 else DEFAULT_WS_URL

    asyncio.run(stream_video(video_arg, url_arg))
