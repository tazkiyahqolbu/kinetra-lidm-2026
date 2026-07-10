import json
import math

import numpy as np

from ai_engine.angle import AngleCalculator


def test_calculate_right_angle():

    hip = (1, 2)
    knee = (2, 2)
    ankle = (2, 1)

    angle = AngleCalculator.calculate(hip, knee, ankle)

    assert angle == 90.0


def test_calculate_straight_leg_is_180():

    hip = (0, 2)
    knee = (0, 1)
    ankle = (0, 0)

    angle = AngleCalculator.calculate(hip, knee, ankle)

    assert angle == 180.0


def test_calculate_hip_and_knee_overlapping_does_not_produce_nan():

    # Degenerate keypoints (e.g. noisy detection at a distance) can put
    # hip exactly on top of knee - the zero-length vector must not
    # propagate NaN downstream (NaN breaks JSON.parse on the browser side).
    hip = (5, 5)
    knee = (5, 5)
    ankle = (5, 10)

    angle = AngleCalculator.calculate(hip, knee, ankle)

    assert math.isfinite(angle)


def test_calculate_knee_and_ankle_overlapping_does_not_produce_nan():

    hip = (5, 0)
    knee = (5, 5)
    ankle = (5, 5)

    angle = AngleCalculator.calculate(hip, knee, ankle)

    assert math.isfinite(angle)


def test_calculate_nan_keypoint_input_does_not_produce_nan():

    # The pose model itself can return NaN/inf for a keypoint it treats
    # as "not visible" - this must not leak through (NaN != 0, so a
    # zero-length-vector check alone would miss this case).
    hip = (float("nan"), float("nan"))
    knee = (100, 100)
    ankle = (100, 150)

    angle = AngleCalculator.calculate(hip, knee, ankle)

    assert math.isfinite(angle)


def test_calculate_inf_keypoint_input_does_not_produce_nan():

    hip = (100, 100)
    knee = (float("inf"), 50)
    ankle = (100, 150)

    angle = AngleCalculator.calculate(hip, knee, ankle)

    assert math.isfinite(angle)


def test_calculate_returns_plain_python_float_not_numpy_float32():

    # Real YOLO/PyTorch keypoints are numpy.float32, not float64. Unlike
    # float64 (which happens to subclass Python's float and therefore
    # sails through json.dumps unnoticed), float32 is NOT JSON-serializable
    # and crashes json.dumps with an uncaught TypeError - which is exactly
    # what silently killed the whole WebSocket connection in production.
    hip = np.array([1, 2], dtype=np.float32)
    knee = np.array([2, 2], dtype=np.float32)
    ankle = np.array([2, 1], dtype=np.float32)

    angle = AngleCalculator.calculate(hip, knee, ankle)

    assert type(angle) is float

    # must not raise TypeError: Object of type float32 is not JSON serializable
    json.dumps({"angle": angle})
