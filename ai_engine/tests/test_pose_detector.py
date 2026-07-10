import cv2

from ai_engine.pose_detector import PoseDetector


detector = PoseDetector()

camera = cv2.VideoCapture(0)

while True:

    ret, frame = camera.read()

    if not ret:
        break

    results = detector.detect(frame)

    output = results[0].plot()

    cv2.imshow("YOLO Pose", output)

    if cv2.waitKey(1) == ord("q"):
        break

camera.release()
cv2.destroyAllWindows()
