from ai_engine.filters import EMAFilter


def test_first_value_passes_through_unchanged():

    ema = EMAFilter(alpha=0.2)

    assert ema.update(180) == 180


def test_smoothing_matches_ema_formula():

    ema = EMAFilter(alpha=0.2)

    angles = [180, 175, 170, 160, 150, 140, 130]

    expected = [180, 179.0, 177.2, 173.76, 169.01, 163.21, 156.57]

    output = [ema.update(angle) for angle in angles]

    assert output == expected
