import os

import numpy as np

from ai_engine.report import ReportGenerator


def test_generate_report_builds_summary_csv_and_graph():

    report = ReportGenerator()

    angles = []

    for _ in range(4):
        angles.extend(np.linspace(180, 90, 30))
        angles.extend(np.linspace(90, 180, 30))

    result = report.generate(angles)

    try:
        assert result["summary"]["repetition"] == 4
        assert result["summary"]["average_depth"] == 90.0
        assert result["summary"]["average_standing"] == 180.0
        assert result["summary"]["range_of_motion"] == 90.0

        assert os.path.exists(result["csv"])
        assert os.path.exists(result["graph"])

    finally:
        os.remove(result["csv"])
        os.remove(result["graph"])
