from ai_engine.session import SquatSession


def _fake_clock():
    """Advances by 2.5s every call -> lands tempo squarely in the 'good' bucket."""

    state = {"t": 0.0}

    def clock():
        state["t"] += 2.5
        return state["t"]

    return clock


# Standing -> Descending -> Bottom -> Ascending -> Standing, once smoothed
# through the EMA filter (unlike the raw-angle fixture used in
# test_state_machine.py, this has to move far enough/long enough to still
# cross every threshold after EMA(alpha=0.2) smoothing).
ONE_REP_CYCLE = [180] * 3 + [140] * 5 + [80] * 8 + [140] * 5 + [180] * 8


def test_full_squat_cycle_matches_state_machine_and_scoring():

    session = SquatSession(clock=_fake_clock())

    results = [session.process_angle(angle) for angle in ONE_REP_CYCLE]

    states_seen = [r["state"] for r in results]

    assert states_seen[0] == "Standing"
    assert "Descending" in states_seen
    assert "Bottom" in states_seen
    assert "Ascending" in states_seen
    assert states_seen[-1] == "Standing"

    completed = [r for r in results if r["event"] == "REP_COMPLETED"]

    assert len(completed) == 1

    result = completed[0]["result"]

    assert result["repetition"] == 1
    assert result["movement_score"]["final"] > 0

    # Stability dinilai dari jitter antar-frame, bukan rentang gerak
    # penuh (yang wajar besar di setiap squat) - jadi squat normal harus
    # dapat skor lebih baik dari nilai minimum (65).
    assert result["movement_score"]["stability"] > 65
    assert result["risk"]["risk_level"] in {"LOW", "MEDIUM", "HIGH"}
    assert {f["code"] for f in result["feedback"]} & {
        "DEPTH_LOW", "DEPTH_OVER", "DEPTH_GOOD",
    }

    assert session.last_result == result
    assert len(session.angle_history) == len(ONE_REP_CYCLE)

    # rep-tracking state resets after completion
    assert session.rep_start_time is None
    assert session.rep_min_angle == 180
    assert session.rep_angles == []


def test_session_is_safe_to_reuse_across_multiple_reps():

    session = SquatSession(clock=_fake_clock())

    for angle in ONE_REP_CYCLE:
        session.process_angle(angle)

    assert session.state_machine.repetition == 1
    first_result = session.last_result
    assert first_result is not None

    for angle in ONE_REP_CYCLE:
        session.process_angle(angle)

    assert session.state_machine.repetition == 2
    second_result = session.last_result
    assert second_result is not None

    assert first_result is not second_result
    assert second_result["repetition"] == 2


# Turun sedikit (masuk Descending) lalu naik lagi tanpa sempat sampai Bottom.
ABORTED_DESCENT = [180] * 3 + [140] * 5 + [80] * 1 + [180] * 10


def test_aborted_descent_resets_rep_tracking_instead_of_getting_stuck():
    session = SquatSession(clock=_fake_clock())

    results = [session.process_angle(angle) for angle in ABORTED_DESCENT]

    # Sesi harus kembali ke Standing, bukan macet di Descending.
    assert results[-1]["state"] == "Standing"
    assert session.rep_start_time is None
    assert session.rep_angles == []
    assert all(r["event"] is None for r in results)

    # Rep yang batal tidak boleh menghalangi rep penuh berikutnya.
    completed = [
        r for r in [session.process_angle(a) for a in ONE_REP_CYCLE]
        if r["event"] == "REP_COMPLETED"
    ]

    assert len(completed) == 1
    assert completed[0]["result"]["repetition"] == 1
