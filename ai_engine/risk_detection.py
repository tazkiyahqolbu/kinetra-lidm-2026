"""
=====================================
KINETRA RISK DETECTION
=====================================
"""


class RiskDetection:

    def __init__(self):

        self.level = "LOW"
        self.score = 0
        self.reasons = []

    # ==========================================
    # DETECT RISK
    # ==========================================

    def evaluate(
        self,
        depth_score,
        tempo_score,
        stability_score
    ):

        self.score = 0
        self.reasons = []

        # ----------------------------
        # DEPTH
        # ----------------------------

        if depth_score < 80:

            self.score += 1

            self.reasons.append(
                "Kedalaman squat kurang optimal."
            )

        # ----------------------------
        # TEMPO
        # ----------------------------

        if tempo_score < 80:

            self.score += 1

            self.reasons.append(
                "Tempo gerakan tidak ideal."
            )

        # ----------------------------
        # STABILITY
        # ----------------------------

        if stability_score < 80:

            self.score += 1

            self.reasons.append(
                "Gerakan kurang stabil."
            )

        # ----------------------------
        # FINAL LEVEL
        # ----------------------------

        if self.score == 0:

            self.level = "LOW"

        elif self.score == 1:

            self.level = "MEDIUM"

        else:

            self.level = "HIGH"

        return {

            "risk_level": self.level,

            "risk_score": self.score,

            "reasons": self.reasons

        }
