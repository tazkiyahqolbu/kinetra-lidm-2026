from ai_engine.movement_score import MovementScore


def test_depth_score_penalizes_deviation_from_ideal_angle():

    score = MovementScore()

    assert score.calculate_depth_score(95) == 92.5
    assert score.calculate_depth_score(90) == 100
    assert score.calculate_depth_score(0) == 0


def test_tempo_score_buckets():

    score = MovementScore()

    assert score.calculate_tempo_score(2.5) == 100
    assert score.calculate_tempo_score(1.8) == 90
    assert score.calculate_tempo_score(5) == 70


def test_stability_score_buckets():

    score = MovementScore()

    assert score.calculate_stability_score(2) == 100
    assert score.calculate_stability_score(5) == 90
    assert score.calculate_stability_score(8) == 80
    assert score.calculate_stability_score(20) == 65


def test_final_score_is_weighted_average():

    score = MovementScore()

    score.calculate_depth_score(95)
    score.calculate_tempo_score(2.5)
    score.calculate_stability_score(2)

    assert score.calculate_final_score() == 97.0
