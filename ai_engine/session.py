import time

from ai_engine.filters import EMAFilter
from ai_engine.state_machine import SquatStateMachine
from ai_engine.movement_score import MovementScore
from ai_engine.feedback import FeedbackEngine
from ai_engine.risk_detection import RiskDetection
from ai_engine.config import EMA_ALPHA


class SquatSession:
    """Menyimpan state satu sesi latihan (filter, state machine, pelacak
    repetisi) dan mengubah aliran sudut lutut mentah jadi hasil
    repetisi/skor/feedback/risiko. Tidak bergantung kamera/GUI, jadi bisa
    dipakai ulang oleh loop CLI desktop, server WebSocket, maupun test.
    """

    def __init__(self, ema_alpha=EMA_ALPHA, clock=time.time):
        self.filter = EMAFilter(alpha=ema_alpha)
        self.state_machine = SquatStateMachine()
        self.score_engine = MovementScore()
        self.feedback_engine = FeedbackEngine()
        self.risk_engine = RiskDetection()
        self._clock = clock

        self.angle_history = []

        self.rep_start_time = None
        self.rep_min_angle = 180
        self.rep_angles = []
        self.last_result = None

    def process_angle(self, raw_angle):
        angle = self.filter.update(raw_angle)
        previous_state = self.state_machine.state.value
        state = self.state_machine.update(angle)
        self.angle_history.append(angle)

        event = state["event"]
        result = None

        entered_descending = (
            state["state"] == "Descending" and previous_state != "Descending"
        )
        aborted_to_standing = (
            state["state"] == "Standing" and event != "REP_COMPLETED"
        )

        # Masuk fase turun (dari Standing normal, atau dari Ascending yang
        # turun lagi) -> mulai lacak repetisi dari nol.
        if entered_descending:
            self.rep_start_time = self._clock()
            self.rep_min_angle = angle
            self.rep_angles = []
        # Balik ke Standing tanpa rep selesai (dibatalkan sebelum bottom) ->
        # buang data pelacakan yang nggak jadi rep.
        elif aborted_to_standing:
            self.rep_start_time = None
            self.rep_min_angle = 180
            self.rep_angles = []

        if self.rep_start_time is not None:
            self.rep_angles.append(angle)
            self.rep_min_angle = min(self.rep_min_angle, angle)

        if event == "REP_COMPLETED":
            duration = self._clock() - self.rep_start_time
            jitter = self._average_jitter(self.rep_angles)

            self.score_engine.calculate_depth_score(self.rep_min_angle)
            self.score_engine.calculate_tempo_score(duration)
            self.score_engine.calculate_stability_score(jitter)

            movement_score = {
                "depth": self.score_engine.depth_score,
                "tempo": self.score_engine.tempo_score,
                "stability": self.score_engine.stability_score,
                "final": self.score_engine.calculate_final_score(),
            }

            self.feedback_engine.feedbacks = []
            self.feedback_engine.evaluate_depth(self.rep_min_angle)
            self.feedback_engine.evaluate_tempo(duration)
            feedback = self.feedback_engine.get_feedback()

            risk = self.risk_engine.evaluate(
                movement_score["depth"],
                movement_score["tempo"],
                movement_score["stability"],
            )

            result = {
                "repetition": state["repetition"],
                "movement_score": movement_score,
                "feedback": feedback,
                "risk": risk,
            }
            self.last_result = result

            # Reset pelacak buat repetisi berikutnya
            self.rep_start_time = None
            self.rep_min_angle = 180
            self.rep_angles = []

        return {
            "angle": angle,
            "state": state["state"],
            "repetition": state["repetition"],
            "event": event,
            "result": result,
        }

    @staticmethod
    def _average_jitter(angles):
        """Rata-rata selisih absolut antar-frame berurutan - ukuran
        goyang/noise gerakan, bukan seberapa jauh rentang totalnya.
        """
        if len(angles) < 2:
            return 0

        diffs = [abs(angles[i] - angles[i - 1]) for i in range(1, len(angles))]
        return sum(diffs) / len(diffs)
