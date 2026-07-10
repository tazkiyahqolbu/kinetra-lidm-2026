class EMAFilter:
    """
    Exponential Moving Average (EMA)
    untuk menghaluskan perubahan sudut.
    """

    def __init__(self, alpha=0.2):

        self.alpha = alpha
        self.previous = None

    def update(self, value):

        if self.previous is None:
            self.previous = value
            return value

        smoothed = (
            self.alpha * value
        ) + (
            (1 - self.alpha) * self.previous
        )

        self.previous = smoothed

        return round(smoothed, 2)
