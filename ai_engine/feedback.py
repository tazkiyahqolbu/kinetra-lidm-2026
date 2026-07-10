"""
=====================================
KINETRA FEEDBACK ENGINE
=====================================
"""


class FeedbackEngine:

    def __init__(self):

        self.feedbacks = []

    # ==========================================
    # DEPTH
    # ==========================================

    def evaluate_depth(self, angle):

        if angle > 110:

            self.feedbacks.append({

                "code": "DEPTH_LOW",

                "level": "warning",

                "message": "Turunkan posisi squat agar mencapai kedalaman ideal."

            })

        elif angle < 75:

            self.feedbacks.append({

                "code": "DEPTH_OVER",

                "level": "warning",

                "message": "Posisi squat terlalu dalam."

            })

        else:

            self.feedbacks.append({

                "code": "DEPTH_GOOD",

                "level": "success",

                "message": "Kedalaman squat sudah baik."

            })

    # ==========================================
    # TEMPO
    # ==========================================

    def evaluate_tempo(self, duration):

        if duration < 2:

            self.feedbacks.append({

                "code": "TEMPO_FAST",

                "level": "warning",

                "message": "Gerakan terlalu cepat."

            })

        elif duration > 3:

            self.feedbacks.append({

                "code": "TEMPO_SLOW",

                "level": "warning",

                "message": "Gerakan terlalu lambat."

            })

        else:

            self.feedbacks.append({

                "code": "TEMPO_GOOD",

                "level": "success",

                "message": "Tempo gerakan sudah baik."

            })

    # ==========================================
    # GET RESULT
    # ==========================================

    def get_feedback(self):

        return self.feedbacks
