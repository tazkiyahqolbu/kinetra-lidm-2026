"""
=====================================
KINETRA AI ENGINE CONFIGURATION
=====================================
"""

# ==============================
# YOLO MODEL
# ==============================

MODEL_PATH = "models/yolov8n-pose.pt"

# ==============================
# CAMERA
# ==============================

CAMERA_INDEX = 0

FRAME_WIDTH = 640
FRAME_HEIGHT = 480

# ==============================
# DISPLAY
# ==============================

WINDOW_NAME = "KINETRA AI Engine"

# ==============================
# EMA FILTER
# ==============================

EMA_ALPHA = 0.2

# ==============================
# ANGLE THRESHOLD
# ==============================

STANDING_ANGLE = 165
DESCENDING_ANGLE = 150
BOTTOM_ANGLE = 120
ASCENDING_ANGLE = 135
