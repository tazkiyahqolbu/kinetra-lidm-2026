import cv2
from ultralytics import YOLO

from ai_engine.config import MODEL_PATH


class PoseDetector:
    """Deteksi pose pakai YOLOv8-Pose: load model, deteksi pose, dan
    mengembalikan keypoints.
    """

    def __init__(self, confidence=0.5):
        self.confidence = confidence
        self.model = YOLO(MODEL_PATH)

    def detect(self, frame):
        return self.model(frame, verbose=False, conf=self.confidence)

    def get_keypoints(self, results):
        if len(results) == 0 or len(results[0].keypoints) == 0:
            return None

        return results[0].keypoints.xy.cpu().numpy()[0]

    def get_confidence(self, results):
        if len(results) == 0 or len(results[0].keypoints) == 0:
            return None

        return results[0].keypoints.conf.cpu().numpy()[0]

    def draw(self, results):
        if len(results) == 0:
            return None

        return results[0].plot()

    def has_required_landmarks(self, confidence, threshold=0.5):
        if confidence is None:
            return False

        IDX_HIP = 12
        IDX_KNEE = 14
        IDX_ANKLE = 16

        return (
            confidence[IDX_HIP] > threshold
            and confidence[IDX_KNEE] > threshold
            and confidence[IDX_ANKLE] > threshold
        )

    def get_right_leg(self, keypoints):
        IDX_HIP = 12
        IDX_KNEE = 14
        IDX_ANKLE = 16

        return keypoints[IDX_HIP], keypoints[IDX_KNEE], keypoints[IDX_ANKLE]
