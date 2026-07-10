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
