import asyncio
import numpy as np
import cv2
from unittest.mock import patch, MagicMock

from fastapi.testclient import TestClient

from ai_engine import ws_server


class FakeTensor:

    def __init__(self, data):
        self._data = np.array(data)

    def cpu(self):
        return self

    def numpy(self):
        return self._data


class FakeKeypoints:

    def __init__(self, xy, conf):
        self._num_people = len(xy)
        self.xy = FakeTensor(xy)
        self.conf = FakeTensor(conf)

    def __len__(self):
        return self._num_people


class FakeResult:

    def __init__(self, keypoints):
        self.keypoints = keypoints


def _make_results(confident):

    xy = np.zeros((1, 17, 2))

    xy[0, 12] = [10, 10]  # hip
    xy[0, 14] = [10, 20]  # knee
    xy[0, 16] = [10, 30]  # ankle

    conf_value = 0.9 if confident else 0.1

    conf = np.full((1, 17), conf_value)

    return [FakeResult(FakeKeypoints(xy, conf))]


def _jpeg_bytes():

    frame = np.zeros((32, 32, 3), dtype=np.uint8)

    ok, buffer = cv2.imencode(".jpg", frame)

    assert ok

    return buffer.tobytes()


def test_no_pose_when_confidence_is_low():

    fake_detector = MagicMock()
    fake_detector.detect.return_value = _make_results(confident=False)
    fake_detector.get_keypoints.return_value = _make_results(confident=False)[0].keypoints.xy.cpu().numpy()[0]
    fake_detector.get_confidence.return_value = _make_results(confident=False)[0].keypoints.conf.cpu().numpy()[0]
    fake_detector.has_required_landmarks.return_value = False
    fake_detector.draw.return_value = np.zeros((32, 32, 3), dtype=np.uint8)

    with patch("ai_engine.ws_server.PoseDetector", return_value=fake_detector):

        with TestClient(ws_server.app) as client:

            with client.websocket_connect("/ws/squat") as ws:

                ws.send_text('{"type": "start"}')

                ws.send_bytes(_jpeg_bytes())

                message = ws.receive_json()

                assert message["type"] == "no_pose"
                assert isinstance(message["annotated_frame"], str)
                assert len(message["annotated_frame"]) > 0

                ws.send_text('{"type": "stop"}')


def test_frame_result_when_pose_is_confident():

    results = _make_results(confident=True)

    fake_detector = MagicMock()
    fake_detector.detect.return_value = results
    fake_detector.get_keypoints.return_value = results[0].keypoints.xy.cpu().numpy()[0]
    fake_detector.get_confidence.return_value = results[0].keypoints.conf.cpu().numpy()[0]
    fake_detector.has_required_landmarks.return_value = True
    fake_detector.get_right_leg.return_value = ((10, 10), (10, 20), (10, 30))
    fake_detector.draw.return_value = np.zeros((32, 32, 3), dtype=np.uint8)

    with patch("ai_engine.ws_server.PoseDetector", return_value=fake_detector):

        with TestClient(ws_server.app) as client:

            with client.websocket_connect("/ws/squat") as ws:

                ws.send_text('{"type": "start"}')

                ws.send_bytes(_jpeg_bytes())

                message = ws.receive_json()

                assert message["type"] == "frame_result"
                assert message["state"] == "Standing"
                assert message["repetition"] == 0
                assert message["event"] is None
                assert isinstance(message["angle"], (int, float))
                assert isinstance(message["annotated_frame"], str)
                assert len(message["annotated_frame"]) > 0

                ws.send_text('{"type": "stop"}')


def test_frame_result_with_float32_keypoints_does_not_crash_connection():

    # Real YOLO/PyTorch keypoints are numpy.float32, not float64 - this is
    # the exact dtype that used to crash json.dumps mid-connection
    # (float64 happens to subclass Python's float and slips through
    # unnoticed, float32 does not). Regression test for that production
    # incident: the connection must survive and return a valid response.
    results = _make_results(confident=True)

    fake_detector = MagicMock()
    fake_detector.detect.return_value = results
    fake_detector.get_keypoints.return_value = results[0].keypoints.xy.cpu().numpy()[0]
    fake_detector.get_confidence.return_value = results[0].keypoints.conf.cpu().numpy()[0]
    fake_detector.has_required_landmarks.return_value = True
    fake_detector.get_right_leg.return_value = (
        np.array([10, 10], dtype=np.float32),
        np.array([10, 20], dtype=np.float32),
        np.array([10, 30], dtype=np.float32),
    )
    fake_detector.draw.return_value = np.zeros((32, 32, 3), dtype=np.uint8)

    with patch("ai_engine.ws_server.PoseDetector", return_value=fake_detector):

        with TestClient(ws_server.app) as client:

            with client.websocket_connect("/ws/squat") as ws:

                ws.send_text('{"type": "start"}')
                ws.send_bytes(_jpeg_bytes())

                message = ws.receive_json()

                assert message["type"] == "frame_result"
                assert isinstance(message["angle"], (int, float))

                ws.send_text('{"type": "stop"}')


def test_send_json_safely_recovers_from_serialization_error():

    calls = []

    class FakeWebSocket:

        async def send_json(self, payload):

            calls.append(payload)

            if len(calls) == 1:
                raise TypeError("Object of type float32 is not JSON serializable")

    asyncio.run(
        ws_server._send_json_safely(FakeWebSocket(), {"type": "frame_result", "angle": object()})
    )

    assert len(calls) == 2
    assert calls[1] == {"type": "no_pose", "annotated_frame": None}


def test_health_endpoint():

    with patch("ai_engine.ws_server.PoseDetector", return_value=MagicMock()):

        with TestClient(ws_server.app) as client:

            response = client.get("/health")

            assert response.status_code == 200
            assert response.json() == {"status": "ok"}
