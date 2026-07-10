"""
=====================================
KINETRA MOVEMENT QUALITY SCORING
=====================================
"""


class MovementScore:

    def __init__(self):

        self.depth_score = 0
        self.tempo_score = 0
        self.stability_score = 0

    # ==========================================
    # DEPTH SCORE
    # ==========================================

    def calculate_depth_score(
        self,
        current_angle,
        ideal_angle=90
    ):
        """
        Menghitung skor berdasarkan
        deviasi dari sudut ideal.
        """

        error = abs(current_angle - ideal_angle)

        score = max(0, 100 - (error * 1.5))

        self.depth_score = round(score, 2)

        return self.depth_score

    # ==========================================
    # TEMPO SCORE
    # ==========================================

    def calculate_tempo_score(
        self,
        repetition_duration
    ):
        """
        Ideal squat:
        2 - 3 detik
        """

        if 2 <= repetition_duration <= 3:

            self.tempo_score = 100

        elif 1.5 <= repetition_duration <= 4:

            self.tempo_score = 90

        else:

            self.tempo_score = 70

        return self.tempo_score

    # ==========================================
    # STABILITY SCORE
    # ==========================================

    def calculate_stability_score(
        self,
        angle_variation
    ):
        """
        angle_variation
        = standar deviasi sudut
        """

        if angle_variation <= 3:

            self.stability_score = 100

        elif angle_variation <= 6:

            self.stability_score = 90

        elif angle_variation <= 10:

            self.stability_score = 80

        else:

            self.stability_score = 65

        return self.stability_score

    # ==========================================
    # FINAL SCORE
    # ==========================================

    def calculate_final_score(self):

        final_score = (

            (self.depth_score * 0.4)

            +

            (self.tempo_score * 0.3)

            +

            (self.stability_score * 0.3)

        )

        return round(final_score, 2)
