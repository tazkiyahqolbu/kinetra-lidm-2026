from enum import Enum

from ai_engine.config import (
    STANDING_ANGLE,
    DESCENDING_ANGLE,
    BOTTOM_ANGLE,
    ASCENDING_ANGLE,
)


class SquatState(Enum):
    STANDING = "Standing"
    DESCENDING = "Descending"
    BOTTOM = "Bottom"
    ASCENDING = "Ascending"


class SquatStateMachine:
    """Melacak fase squat tiap frame dan menghitung repetisi yang selesai.

    Threshold transisi naik/turun dibedakan (150 saat turun, 135 saat naik,
    bukan satu angka 150 yang sama) supaya sudut lutut yang goyang dikit
    di sekitar batas nggak bikin state bolak-balik tiap frame.
    """

    def __init__(self):
        self.state = SquatState.STANDING
        self.repetition = 0

    def update(self, angle):
        event = None

        if self.state == SquatState.STANDING and angle < DESCENDING_ANGLE:
            self.state = SquatState.DESCENDING

        elif self.state == SquatState.DESCENDING:
            if angle < BOTTOM_ANGLE:
                self.state = SquatState.BOTTOM
            elif angle >= STANDING_ANGLE:
                # Naik lagi tanpa sempat sampai bottom - rep dibatalkan.
                self.state = SquatState.STANDING

        elif self.state == SquatState.BOTTOM and angle > ASCENDING_ANGLE:
            self.state = SquatState.ASCENDING

        elif self.state == SquatState.ASCENDING:
            if angle > STANDING_ANGLE:
                self.state = SquatState.STANDING
                self.repetition += 1
                event = "REP_COMPLETED"
            elif angle <= BOTTOM_ANGLE:
                # Balik turun sampai wilayah bottom lagi tanpa sempat
                # berdiri tegak - hitung sebagai awal turun baru, bukan
                # macet di Ascending. (BOTTOM_ANGLE dipakai, bukan
                # DESCENDING_ANGLE, karena begitu masuk Ascending, angle
                # sudah pasti di atas 135 - rentang 135-150 masih bagian
                # jalur naik yang wajar, bukan tanda batal.)
                self.state = SquatState.DESCENDING

        return {
            "state": self.state.value,
            "repetition": self.repetition,
            "event": event,
        }

