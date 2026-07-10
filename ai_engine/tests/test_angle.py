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
