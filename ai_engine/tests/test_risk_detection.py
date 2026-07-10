from ai_engine.risk_detection import RiskDetection


def test_two_weak_scores_yield_high_risk():

    risk = RiskDetection()

    result = risk.evaluate(
        depth_score=72,
        tempo_score=100,
        stability_score=65
    )

    assert result["risk_level"] == "HIGH"
    assert result["risk_score"] == 2
    assert len(result["reasons"]) == 2


def test_all_good_scores_yield_low_risk():

    risk = RiskDetection()

    result = risk.evaluate(
        depth_score=100,
        tempo_score=100,
        stability_score=100
    )

    assert result["risk_level"] == "LOW"
    assert result["risk_score"] == 0
    assert result["reasons"] == []


def test_single_weak_score_yields_medium_risk():

    risk = RiskDetection()

    result = risk.evaluate(
        depth_score=100,
        tempo_score=70,
        stability_score=100
    )

    assert result["risk_level"] == "MEDIUM"
    assert result["risk_score"] == 1
