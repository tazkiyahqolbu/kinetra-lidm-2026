"""
=====================================
KINETRA REPORT GENERATOR
=====================================
"""

import os
import time
import numpy as np
import pandas as pd
import matplotlib.pyplot as plt

from scipy.signal import find_peaks

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

OUTPUT_DIR = os.path.join(BASE_DIR, "outputs")


class ReportGenerator:

    def __init__(self):

        os.makedirs(os.path.join(OUTPUT_DIR, "csv"), exist_ok=True)
        os.makedirs(os.path.join(OUTPUT_DIR, "images"), exist_ok=True)

    # =====================================================
    # ANALYZE SIGNAL
    # =====================================================

    def analyze_signal(self, angles, fps=30):

        angles = np.array(angles)

        valleys, _ = find_peaks(
            -angles,
            prominence=40,
            distance=30
        )

        peaks, _ = find_peaks(
            angles,
            prominence=30,
            distance=30
        )

        return peaks, valleys

    # =====================================================
    # CREATE MOVEMENT LABEL
    # =====================================================

    def create_phase_labels(
        self,
        angles,
        peaks,
        valleys
    ):

        labels = [

            "Undefined"

            for _ in range(len(angles))

        ]

        for v in valleys:

            labels[v] = "Bottom"

        for p in peaks:

            labels[p] = "Standing"

        return labels

    # =====================================================
    # EXPORT CSV
    # =====================================================

    def export_csv(

        self,

        angles,

        labels

    ):

        timestamp = str(

            int(time.time())

        )

        filename = os.path.join(

            OUTPUT_DIR,

            "csv",

            f"squat_{timestamp}.csv"

        )

        dataframe = pd.DataFrame(

            {

                "Frame":

                    range(len(angles)),

                "Knee Angle":

                    np.round(

                        angles,

                        2

                    ),

                "Movement":

                    labels

            }

        )

        dataframe.to_csv(

            filename,

            index=False

        )

        return filename

    # =====================================================
    # EXPORT GRAPH
    # =====================================================

    def export_graph(

        self,

        angles,

        peaks,

        valleys

    ):

        timestamp = str(

            int(time.time())

        )

        filename = os.path.join(

            OUTPUT_DIR,

            "images",

            f"squat_{timestamp}.png"

        )

        plt.figure(

            figsize=(12,5)

        )

        plt.plot(

            angles,

            linewidth=2,

            label="Knee Angle"

        )

        if len(peaks):

            plt.scatter(

                peaks,

                np.array(angles)[peaks],

                label="Standing"

            )

        if len(valleys):

            plt.scatter(

                valleys,

                np.array(angles)[valleys],

                label="Bottom"

            )

        plt.grid(True)

        plt.legend()

        plt.xlabel("Frame")

        plt.ylabel("Angle")

        plt.tight_layout()

        plt.savefig(

            filename,

            dpi=150

        )

        plt.close()

        return filename

    # =====================================================
    # SUMMARY
    # =====================================================

    def create_summary(

        self,

        angles,

        peaks,

        valleys

    ):

        if len(valleys):

            avg_depth = float(

                np.mean(

                    np.array(angles)[valleys]

                )

            )

        else:

            avg_depth = 0

        if len(peaks):

            avg_standing = float(

                np.mean(

                    np.array(angles)[peaks]

                )

            )

        else:

            avg_standing = 180

        rom = (

            avg_standing

            -

            avg_depth

        )

        return {

            "repetition":

                len(valleys),

            "average_depth":

                round(

                    avg_depth,

                    2

                ),

            "average_standing":

                round(

                    avg_standing,

                    2

                ),

            "range_of_motion":

                round(

                    rom,

                    2

                )

        }

    # =====================================================
    # GENERATE REPORT
    # =====================================================

    def generate(

        self,

        angles

    ):

        peaks, valleys = self.analyze_signal(

            angles

        )

        labels = self.create_phase_labels(

            angles,

            peaks,

            valleys

        )

        csv_file = self.export_csv(

            angles,

            labels

        )

        graph_file = self.export_graph(

            angles,

            peaks,

            valleys

        )

        summary = self.create_summary(

            angles,

            peaks,

            valleys

        )

        return {

            "summary":

                summary,

            "csv":

                csv_file,

            "graph":

                graph_file

        }
