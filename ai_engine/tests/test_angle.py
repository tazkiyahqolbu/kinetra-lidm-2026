from ai_engine.angle import AngleCalculator


hip = (1, 2)
knee = (2, 2)
ankle = (2, 1)

angle = AngleCalculator.calculate(
    hip,
    knee,
    ankle
)

print(angle)
