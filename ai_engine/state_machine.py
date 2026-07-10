from enum import Enum

from ai_engine.config import (
    STANDING_ANGLE,
    DESCENDING_ANGLE,
    BOTTOM_ANGLE,
    ASCENDING_ANGLE
)


class SquatState(Enum):

    STANDING = "Standing"

    DESCENDING = "Descending"

    BOTTOM = "Bottom"

    ASCENDING = "Ascending"


class SquatStateMachine:

    def __init__(self):

        self.state = SquatState.STANDING

        self.repetition = 0

    def update(self, angle):

        event = None

        # ==========================
        # STANDING
        # ==========================

        if self.state == SquatState.STANDING:

            if angle < DESCENDING_ANGLE:

                self.state = SquatState.DESCENDING

        # ==========================
        # DESCENDING
        # ==========================

        elif self.state == SquatState.DESCENDING:

            if angle < BOTTOM_ANGLE:

                self.state = SquatState.BOTTOM

        # ==========================
        # BOTTOM
        # ==========================

        elif self.state == SquatState.BOTTOM:

            if angle > ASCENDING_ANGLE:

                self.state = SquatState.ASCENDING

        # ==========================
        # ASCENDING
        # ==========================

        elif self.state == SquatState.ASCENDING:

            if angle > STANDING_ANGLE:

                self.state = SquatState.STANDING

                self.repetition += 1

                event = "REP_COMPLETED"

        return {

            "state": self.state.value,

            "repetition": self.repetition,

            "event": event
        }
