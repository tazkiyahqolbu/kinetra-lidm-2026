"""
=====================================
KINETRA AI ENGINE
SQUAT ANALYZER
=====================================
"""

import cv2

from ai_engine.pose_detector import PoseDetector
from ai_engine.angle import AngleCalculator
from ai_engine.session import SquatSession
from ai_engine.report import ReportGenerator
from ai_engine.config import (
    CAMERA_INDEX,
    FRAME_WIDTH,
    FRAME_HEIGHT,
    WINDOW_NAME
)


class SquatAnalyzer:

    def __init__(self):

        # ============================
        # ENGINE
        # ============================

        self.detector = PoseDetector()

        self.session = SquatSession()

        self.report_engine = ReportGenerator()

        # ============================
        # HISTORY
        # ============================

        self.frame_history = []

        self.last_result = None

    # ==========================================
    # MAIN ANALYZER
    # ==========================================

    def run(self):

        camera = cv2.VideoCapture(CAMERA_INDEX)

        camera.set(cv2.CAP_PROP_FRAME_WIDTH, FRAME_WIDTH)

        camera.set(cv2.CAP_PROP_FRAME_HEIGHT, FRAME_HEIGHT)

        while True:

            ret, frame = camera.read()

            if not ret:

                break

            results = self.detector.detect(frame)

            output = self.detector.draw(results)

            keypoints = self.detector.get_keypoints(results)

            confidence = self.detector.get_confidence(results)

            if self.detector.has_required_landmarks(confidence):

                hip, knee, ankle = self.detector.get_right_leg(
                    keypoints
                )

                raw_angle = AngleCalculator.calculate(
                    hip,
                    knee,
                    ankle
                )

                frame_result = self.session.process_angle(raw_angle)

                angle = frame_result["angle"]

                self.frame_history.append(
                    frame.copy()
                )

                if frame_result["event"] == "REP_COMPLETED":

                    self.last_result = frame_result["result"]

                # ====================================
                # DISPLAY
                # ====================================

                cv2.putText(

                    output,

                    f"Angle : {angle:.1f}",

                    (20, 40),

                    cv2.FONT_HERSHEY_SIMPLEX,

                    0.8,

                    (0, 255, 0),

                    2

                )

                cv2.putText(

                    output,

                    f"State : {frame_result['state']}",

                    (20, 80),

                    cv2.FONT_HERSHEY_SIMPLEX,

                    0.8,

                    (255, 255, 0),

                    2

                )

                cv2.putText(

                    output,

                    f"Rep : {frame_result['repetition']}",

                    (20, 120),

                    cv2.FONT_HERSHEY_SIMPLEX,

                    0.8,

                    (0, 255, 255),

                    2

                )

                if self.last_result is not None:

                    cv2.putText(

                        output,

                        f"Score : {self.last_result['movement_score']['final']:.1f}",

                        (20, 160),

                        cv2.FONT_HERSHEY_SIMPLEX,

                        0.8,

                        (255, 0, 255),

                        2

                    )

                    cv2.putText(

                        output,

                        f"Risk : {self.last_result['risk']['risk_level']}",

                        (20, 200),

                        cv2.FONT_HERSHEY_SIMPLEX,

                        0.8,

                        (0, 150, 255),

                        2

                    )

            if output is not None:

                cv2.imshow(

                    WINDOW_NAME,

                    output

                )

            key = cv2.waitKey(1) & 0xFF

            if key == ord("q"):

                break

        camera.release()

        cv2.destroyAllWindows()

        # ====================================
        # REPORT
        # ====================================

        report = self.report_engine.generate(

            self.session.angle_history

        )

        if self.last_result is not None:

            report["analysis"] = self.last_result

        return report
