from ultralytics import YOLO
from ai_engine.config import MODEL_PATH


class PoseDetector:

    def __init__(self):

        self.model = YOLO(MODEL_PATH)

    def detect(self, frame):

        results = self.model(frame)

        return results
