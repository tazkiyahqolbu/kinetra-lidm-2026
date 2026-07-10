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

        norm_ba = np.linalg.norm(ba)
        norm_bc = np.linalg.norm(bc)

        # Kondisi degenerate: titik berhimpit (jarak nol) ATAU keypoint
        # model itu sendiri sudah NaN/inf (bisa terjadi kalau model
        # menganggap satu titik "tidak terlihat"). np.isfinite menangkap
        # keduanya - beda dari `== 0` yang gagal mendeteksi NaN (NaN tidak
        # pernah sama dengan apapun, termasuk 0). Tanpa pengaman ini,
        # pembagian/arccos menghasilkan NaN yang lolos sampai ke JSON
        # (bukan JSON valid) dan bikin JSON.parse di browser error/freeze.
        if (
            not np.isfinite(norm_ba)
            or not np.isfinite(norm_bc)
            or norm_ba == 0
            or norm_bc == 0
        ):

            return 180.0

        cosine = np.dot(ba, bc) / (
            norm_ba *
            norm_bc
        )

        cosine = np.clip(cosine, -1.0, 1.0)

        angle = np.degrees(
            np.arccos(cosine)
        )

        result = round(angle, 2)

        # Jaring pengaman terakhir: kalau entah bagaimana masih ada NaN/inf
        # yang lolos dari semua pengecekan di atas, jangan pernah
        # kembalikan itu ke pemanggil.
        if not np.isfinite(result):

            return 180.0

        # PyTorch/YOLO keypoints are float32, not float64 - unlike float64
        # (which happens to subclass Python's float), numpy.float32 is NOT
        # JSON-serializable and crashes json.dumps with an uncaught
        # TypeError, which kills the whole WebSocket connection. Casting
        # to a plain Python float here guarantees every value downstream
        # of this function (filters, state machine, scoring, JSON
        # payloads) is always a native float, regardless of what dtype
        # the caller's keypoints happened to be in.
        return float(result)
