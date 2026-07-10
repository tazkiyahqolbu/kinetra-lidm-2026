"""
=====================================
KINETRA AI ENGINE
SQUAT SESSION (camera/GUI-free)
=====================================
"""

import time

from ai_engine.filters import EMAFilter
from ai_engine.state_machine import SquatStateMachine
from ai_engine.movement_score import MovementScore
from ai_engine.feedback import FeedbackEngine
from ai_engine.risk_detection import RiskDetection
from ai_engine.config import EMA_ALPHA


class SquatSession:
    """
    Holds one exercise session's state (filter, state machine, rep
    tracking) and turns a stream of raw knee angles into rep/score/
    feedback/risk results. Has no camera/GUI dependency, so it can be
    reused by the desktop CLI loop, a WebSocket server, or tests alike.
    """

    def __init__(self, ema_alpha=EMA_ALPHA, clock=time.time):

        self.filter = EMAFilter(alpha=ema_alpha)

        self.state_machine = SquatStateMachine()

        self.score_engine = MovementScore()

        self.feedback_engine = FeedbackEngine()

        self.risk_engine = RiskDetection()

        self._clock = clock

        # ============================
        # HISTORY
        # ============================

        self.angle_history = []

        # ============================
        # REP TRACKER
        # ============================

        self.rep_start_time = None

        self.rep_min_angle = 180

        self.rep_angles = []

        self.last_result = None

    # ==========================================
    # PROCESS ONE RAW ANGLE
    # ==========================================

    def process_angle(self, raw_angle):

        angle = self.filter.update(raw_angle)

        state = self.state_machine.update(angle)

        self.angle_history.append(angle)

        event = state["event"]

        result = None

        # ====================================
        # REP TRACKING
        # ====================================

        if state["state"] == "Descending":

            if self.rep_start_time is None:

                self.rep_start_time = self._clock()

                self.rep_min_angle = angle

                self.rep_angles = []

        if self.rep_start_time is not None:

            self.rep_angles.append(angle)

            if angle < self.rep_min_angle:

                self.rep_min_angle = angle

        # ====================================
        # REP COMPLETED
        # ====================================

        if event == "REP_COMPLETED":

            duration = self._clock() - self.rep_start_time

            variation = max(self.rep_angles) - min(self.rep_angles)

            # ====================================
            # MOVEMENT SCORE
            # ====================================

            self.score_engine.calculate_depth_score(self.rep_min_angle)

            self.score_engine.calculate_tempo_score(duration)

            self.score_engine.calculate_stability_score(variation)

            movement_score = {

                "depth": self.score_engine.depth_score,

                "tempo": self.score_engine.tempo_score,

                "stability": self.score_engine.stability_score,

                "final": self.score_engine.calculate_final_score()

            }

            # ====================================
            # FEEDBACK
            # ====================================

            self.feedback_engine.feedbacks = []

            self.feedback_engine.evaluate_depth(self.rep_min_angle)

            self.feedback_engine.evaluate_tempo(duration)

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

            result = {

                "repetition": state["repetition"],

                "movement_score": movement_score,

                "feedback": feedback,

                "risk": risk

            }

            self.last_result = result

            # RESET REP

            self.rep_start_time = None

            self.rep_min_angle = 180

            self.rep_angles = []

        return {

            "angle": angle,

            "state": state["state"],

            "repetition": state["repetition"],

            "event": event,

            "result": result

        }
