from ai_engine.feedback import FeedbackEngine


def test_shallow_depth_and_fast_tempo_produce_warnings():

    fb = FeedbackEngine()

    fb.evaluate_depth(120)
    fb.evaluate_tempo(1.5)

    feedback = fb.get_feedback()

    codes = [f["code"] for f in feedback]

    assert codes == ["DEPTH_LOW", "TEMPO_FAST"]
    assert all(f["level"] == "warning" for f in feedback)


def test_good_depth_and_tempo_produce_success():

    fb = FeedbackEngine()

    fb.evaluate_depth(90)
    fb.evaluate_tempo(2.5)

    codes = [f["code"] for f in fb.get_feedback()]

    assert codes == ["DEPTH_GOOD", "TEMPO_GOOD"]


def test_over_depth_and_slow_tempo():

    fb = FeedbackEngine()

    fb.evaluate_depth(70)
    fb.evaluate_tempo(4)

    codes = [f["code"] for f in fb.get_feedback()]

    assert codes == ["DEPTH_OVER", "TEMPO_SLOW"]
