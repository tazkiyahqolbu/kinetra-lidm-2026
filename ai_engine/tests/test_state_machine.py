from ai_engine.state_machine import SquatStateMachine


def test_full_squat_cycle_completes_one_repetition():

    fsm = SquatStateMachine()

    angles = [180, 170, 160, 145, 130, 115, 130, 145, 170]

    results = [fsm.update(angle) for angle in angles]

    # transitions: Standing -> Descending -> Bottom -> Ascending -> Standing
    assert [r["state"] for r in results] == [
        "Standing",
        "Standing",
        "Standing",
        "Descending",
        "Descending",
        "Bottom",
        "Bottom",
        "Ascending",
        "Standing",
    ]

    assert results[-1]["repetition"] == 1
    assert results[-1]["event"] == "REP_COMPLETED"

    # no rep should be counted before the cycle closes
    assert all(r["event"] is None for r in results[:-1])


def test_partial_descent_aborts_back_to_standing_without_reaching_bottom():
    fsm = SquatStateMachine()

    # Turun sedikit (masuk Descending) lalu naik lagi tanpa pernah sampai Bottom.
    angles = [180, 145, 130, 170]

    results = [fsm.update(angle) for angle in angles]

    assert [r["state"] for r in results] == [
        "Standing",
        "Descending",
        "Descending",
        "Standing",
    ]

    assert results[-1]["repetition"] == 0
    assert all(r["event"] is None for r in results)


def test_partial_ascent_aborts_back_to_descending_without_reaching_standing():
    fsm = SquatStateMachine()

    # Sampai Bottom, mulai naik (Ascending), lalu turun lagi sampai wilayah
    # Bottom tanpa sempat berdiri tegak.
    angles = [180, 145, 115, 140, 110]

    results = [fsm.update(angle) for angle in angles]

    assert [r["state"] for r in results] == [
        "Standing",
        "Descending",
        "Bottom",
        "Ascending",
        "Descending",
    ]

    assert results[-1]["repetition"] == 0
