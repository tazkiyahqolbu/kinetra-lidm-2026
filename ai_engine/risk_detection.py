class RiskDetection:
    """Menilai level risiko cedera berdasarkan 3 skor gerakan (depth,
    tempo, stability). Tiap skor di bawah 80 dianggap bermasalah dan
    menambah risk_score; jumlah masalah menentukan level akhir.
    """

    def __init__(self):
        self.level = "LOW"
        self.score = 0
        self.reasons = []

    def evaluate(self, depth_score, tempo_score, stability_score):
        self.score = 0
        self.reasons = []

        if depth_score < 80:
            self.score += 1
            self.reasons.append("Kedalaman squat kurang optimal.")

        if tempo_score < 80:
            self.score += 1
            self.reasons.append("Tempo gerakan tidak ideal.")

        if stability_score < 80:
            self.score += 1
            self.reasons.append("Gerakan kurang stabil.")

        if self.score == 0:
            self.level = "LOW"
        elif self.score == 1:
            self.level = "MEDIUM"
        else:
            self.level = "HIGH"

        return {
            "risk_level": self.level,
            "risk_score": self.score,
            "reasons": self.reasons,
        }
