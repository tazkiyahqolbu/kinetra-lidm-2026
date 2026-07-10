import numpy as np

from unittest.mock import patch, MagicMock

from ai_engine.pose_detector import PoseDetector


class FakeTensor:

    def __init__(self, data):
        self._data = np.array(data)

    def cpu(self):
        return self

    def numpy(self):
        return self._data


class FakeKeypoints:

    def __init__(self, xy, conf):
        self._num_people = len(xy)
        self.xy = FakeTensor(xy)
        self.conf = FakeTensor(conf)

    def __len__(self):
        return self._num_people


class FakeResult:

    def __init__(self, keypoints):
        self.keypoints = keypoints

    def plot(self):
        return "plotted_frame"


def _make_detector():

    with patch("ai_engine.pose_detector.YOLO") as mock_yolo:

        mock_yolo.return_value = MagicMock()

        return PoseDetector()


def _make_results(confident=True):

    xy = np.zeros((1, 17, 2))

    xy[0, 12] = [10, 10]  # hip
    xy[0, 14] = [10, 20]  # knee
    xy[0, 16] = [10, 30]  # ankle

    conf_value = 0.9 if confident else 0.1

    conf = np.full((1, 17), conf_value)

    return [FakeResult(FakeKeypoints(xy, conf))]


def test_get_keypoints_and_confidence_from_results():

    detector = _make_detector()
    results = _make_results()

    keypoints = detector.get_keypoints(results)
    confidence = detector.get_confidence(results)

    assert keypoints.shape == (17, 2)
    assert confidence.shape == (17,)


def test_has_required_landmarks_true_when_confident():

    detector = _make_detector()
    results = _make_results(confident=True)

    confidence = detector.get_confidence(results)

    assert detector.has_required_landmarks(confidence)


def test_has_required_landmarks_false_when_low_confidence():

    detector = _make_detector()
    results = _make_results(confident=False)

    confidence = detector.get_confidence(results)

    assert not detector.has_required_landmarks(confidence)


def test_has_required_landmarks_false_when_confidence_is_none():

    detector = _make_detector()

    assert not detector.has_required_landmarks(None)


def test_get_right_leg_returns_hip_knee_ankle():

    detector = _make_detector()
    results = _make_results()

    keypoints = detector.get_keypoints(results)

    hip, knee, ankle = detector.get_right_leg(keypoints)

    assert list(hip) == [10, 10]
    assert list(knee) == [10, 20]
    assert list(ankle) == [10, 30]


def test_draw_returns_none_when_no_results():

    detector = _make_detector()

    assert detector.draw([]) is None
