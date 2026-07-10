from ai_engine.filters import EMAFilter

ema = EMAFilter(alpha=0.2)

angles = [
    180,
    175,
    170,
    160,
    150,
    140,
    130
]

for angle in angles:

    smooth = ema.update(angle)

    print(
        f"Input : {angle}"
    )

    print(
        f"Output: {smooth}"
    )

    print("----------------")
