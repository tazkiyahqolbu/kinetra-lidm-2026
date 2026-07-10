from unittest.mock import patch, MagicMock

from ai_engine.analyzer import SquatAnalyzer
from ai_engine.session import SquatSession
from ai_engine.filters import EMAFilter
from ai_engine.state_machine import SquatStateMachine
from ai_engine.movement_score import MovementScore
from ai_engine.feedback import FeedbackEngine
from ai_engine.risk_detection import RiskDetection
from ai_engine.report import ReportGenerator


@patch("ai_engine.analyzer.PoseDetector")
def test_analyzer_wires_up_all_engines(mock_pose_detector):

    mock_pose_detector.return_value = MagicMock()

    analyzer = SquatAnalyzer()

    assert isinstance(analyzer.session, SquatSession)
    assert isinstance(analyzer.session.filter, EMAFilter)
    assert isinstance(analyzer.session.state_machine, SquatStateMachine)
    assert isinstance(analyzer.session.score_engine, MovementScore)
    assert isinstance(analyzer.session.feedback_engine, FeedbackEngine)
    assert isinstance(analyzer.session.risk_engine, RiskDetection)
    assert isinstance(analyzer.report_engine, ReportGenerator)

    mock_pose_detector.assert_called_once()
