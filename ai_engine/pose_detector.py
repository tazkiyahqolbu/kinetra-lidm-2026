"""
=====================================
KINETRA AI ENGINE
POSE DETECTOR
=====================================
"""

import cv2
from ultralytics import YOLO

from ai_engine.config import MODEL_PATH


class PoseDetector:
    """
    Pose Detector menggunakan YOLOv8 Pose.

    Tugas:
    - Load model
    - Detect pose
    - Mengembalikan keypoints
    """

    def __init__(self, confidence=0.5):

        self.confidence = confidence

        self.model = YOLO(MODEL_PATH)

    # ==========================================
    # DETECT
    # ==========================================

    def detect(self, frame):

        results = self.model(

            frame,

            verbose=False,

            conf=self.confidence

        )

        return results

    # ==========================================
    # GET KEYPOINTS
    # ==========================================

    def get_keypoints(self, results):

        if len(results) == 0:

            return None

        if len(results[0].keypoints) == 0:

            return None

        return results[0].keypoints.xy.cpu().numpy()[0]

    # ==========================================
    # GET CONFIDENCE
    # ==========================================

    def get_confidence(self, results):

        if len(results) == 0:

            return None

        if len(results[0].keypoints) == 0:

            return None

        return results[0].keypoints.conf.cpu().numpy()[0]

    # ==========================================
    # DRAW RESULT
    # ==========================================

    def draw(self, results):

        if len(results) == 0:

            return None

        return results[0].plot()

    # ==========================================
    # CHECK LANDMARK
    # ==========================================

    def has_required_landmarks(

        self,

        confidence,

        threshold=0.5

    ):

        if confidence is None:

            return False

        IDX_HIP = 12
        IDX_KNEE = 14
        IDX_ANKLE = 16

        return (

            confidence[IDX_HIP] > threshold

            and

            confidence[IDX_KNEE] > threshold

            and

            confidence[IDX_ANKLE] > threshold

        )

    # ==========================================
    # GET RIGHT LEG
    # ==========================================

    def get_right_leg(self, keypoints):

        IDX_HIP = 12
        IDX_KNEE = 14
        IDX_ANKLE = 16

        hip = keypoints[IDX_HIP]

        knee = keypoints[IDX_KNEE]

        ankle = keypoints[IDX_ANKLE]

        return hip, knee, ankle
