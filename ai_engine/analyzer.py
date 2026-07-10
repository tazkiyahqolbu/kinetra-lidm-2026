"""
=====================================
KINETRA AI ENGINE
SQUAT ANALYZER
=====================================
"""

import cv2
import time
import numpy as np

from ai_engine.pose_detector import PoseDetector
from ai_engine.angle import AngleCalculator
from ai_engine.filters import EMAFilter
from ai_engine.state_machine import SquatStateMachine
from ai_engine.movement_score import MovementScore
from ai_engine.feedback import FeedbackEngine
from ai_engine.risk_detection import RiskDetection
from ai_engine.report import ReportGenerator
from ai_engine.config import (
    CAMERA_INDEX,
    FRAME_WIDTH,
    FRAME_HEIGHT,
    WINDOW_NAME,
    EMA_ALPHA
)


class SquatAnalyzer:

    def __init__(self):

        # ============================
        # ENGINE
        # ============================

        self.detector = PoseDetector()

        self.filter = EMAFilter(alpha=EMA_ALPHA)

        self.state_machine = SquatStateMachine()

        self.score_engine = MovementScore()

        self.feedback_engine = FeedbackEngine()

        self.risk_engine = RiskDetection()

        self.report_engine = ReportGenerator()

        # ============================
        # HISTORY
        # ============================

        self.angle_history = []

        self.frame_history = []

        # ============================
        # REP TRACKER
        # ============================

        self.rep_start_time = None

        self.rep_min_angle = 180

        self.rep_angles = []

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

                angle = self.filter.update(
                    raw_angle
                )

                state = self.state_machine.update(
                    angle
                )

                self.angle_history.append(
                    angle
                )

                self.frame_history.append(
                    frame.copy()
                )

                # ====================================
                # REP TRACKING
                # ====================================

                if state["state"] == "Descending":

                    if self.rep_start_time is None:

                        self.rep_start_time = time.time()

                        self.rep_min_angle = angle

                        self.rep_angles = []

                if self.rep_start_time is not None:

                    self.rep_angles.append(
                        angle
                    )

                    if angle < self.rep_min_angle:

                        self.rep_min_angle = angle

                # ====================================
                # REP COMPLETED
                # ====================================

                if state["event"] == "REP_COMPLETED":

                    duration = (
                        time.time()
                        -
                        self.rep_start_time
                    )

                    variation = (
                        max(self.rep_angles)
                        -
                        min(self.rep_angles)
                    )

                    # ====================================
                    # MOVEMENT SCORE
                    # ====================================

                    self.score_engine.calculate_depth_score(
                        self.rep_min_angle
                    )

                    self.score_engine.calculate_tempo_score(
                        duration
                    )

                    self.score_engine.calculate_stability_score(
                        variation
                    )

                    movement_score = {

                        "depth":
                            self.score_engine.depth_score,

                        "tempo":
                            self.score_engine.tempo_score,

                        "stability":
                            self.score_engine.stability_score,

                        "final":
                            self.score_engine.calculate_final_score()

                    }

                    # ====================================
                    # FEEDBACK
                    # ====================================

                    self.feedback_engine.feedbacks = []

                    self.feedback_engine.evaluate_depth(
                        self.rep_min_angle
                    )

                    self.feedback_engine.evaluate_tempo(
                        duration
                    )

                    feedback = self.feedback_engine.get_feedback()

                    # ====================================
                    # RISK
                    # ====================================

                    risk = self.risk_engine.evaluate(

                        movement_score["depth"],

                        movement_score["tempo"],

                        movement_score["stability"]

                    )

                    # ====================================
                    # SAVE RESULT
                    # ====================================

                    self.last_result = {

                        "repetition":
                            state["repetition"],

                        "movement_score":
                            movement_score,

                        "feedback":
                            feedback,

                        "risk":
                            risk

                    }

                    # RESET REP

                    self.rep_start_time = None

                    self.rep_min_angle = 180

                    self.rep_angles = []

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

                    f"State : {state['state']}",

                    (20, 80),

                    cv2.FONT_HERSHEY_SIMPLEX,

                    0.8,

                    (255, 255, 0),

                    2

                )

                cv2.putText(

                    output,

                    f"Rep : {state['repetition']}",

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

            self.angle_history

        )

        if self.last_result is not None:

            report["analysis"] = self.last_result

        return report
