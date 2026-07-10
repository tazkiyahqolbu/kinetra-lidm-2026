import numpy as np


class AngleCalculator:

    @staticmethod
    def calculate(a, b, c):
        """
        Menghitung sudut dari tiga titik.

        Parameters
        ----------
        a : tuple/list
            Titik pertama (Hip)

        b : tuple/list
            Titik kedua (Knee)

        c : tuple/list
            Titik ketiga (Ankle)

        Returns
        -------
        float
            Sudut dalam derajat
        """

        a = np.array(a)
        b = np.array(b)
        c = np.array(c)

        ba = a - b
        bc = c - b

        cosine = np.dot(ba, bc) / (
            np.linalg.norm(ba) *
            np.linalg.norm(bc)
        )

        cosine = np.clip(cosine, -1.0, 1.0)

        angle = np.degrees(
            np.arccos(cosine)
        )

        return round(angle, 2)
