class MovementScore:
    """Menilai kualitas gerakan squat berdasarkan kedalaman, tempo, dan
    stabilitas, lalu menggabungkannya jadi satu skor akhir berbobot.
    """

    def __init__(self):
        self.depth_score = 0
        self.tempo_score = 0
        self.stability_score = 0

    def calculate_depth_score(self, current_angle, ideal_angle=90):
        """Skor turun 1.5 poin tiap 1 derajat deviasi dari sudut ideal."""
        error = abs(current_angle - ideal_angle)
        score = max(0, 100 - (error * 1.5))

        self.depth_score = round(score, 2)
        return self.depth_score

    def calculate_tempo_score(self, repetition_duration):
        """Tempo ideal squat: 2-3 detik per repetisi."""
        if 2 <= repetition_duration <= 3:
            self.tempo_score = 100
        elif 1.5 <= repetition_duration <= 4:
            self.tempo_score = 90
        else:
            self.tempo_score = 70

        return self.tempo_score

    def calculate_stability_score(self, jitter):
        """jitter = rata-rata selisih sudut antar-frame berurutan selama
        repetisi. Ini ukuran kehalusan gerakan (goyang/noise antar-frame),
        bukan seberapa jauh rentang gerakannya - itu sudah jadi tugas
        depth_score, dan rentang gerak yang lebar (turun-naik penuh)
        memang wajar terjadi di setiap squat yang benar.
        """
        if jitter <= 3:
            self.stability_score = 100
        elif jitter <= 6:
            self.stability_score = 90
        elif jitter <= 10:
            self.stability_score = 80
        else:
            self.stability_score = 65

        return self.stability_score

    def calculate_final_score(self):
        final_score = (
            (self.depth_score * 0.4)
            + (self.tempo_score * 0.3)
            + (self.stability_score * 0.3)
        )
        return round(final_score, 2)
