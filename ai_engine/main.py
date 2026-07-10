"""
=====================================
KINETRA AI ENGINE
MAIN PROGRAM
=====================================
"""

from ai_engine.analyzer import SquatAnalyzer


def main():

    analyzer = SquatAnalyzer()

    result = analyzer.run()

    print("\n==============================")
    print("KINETRA ANALYSIS RESULT")
    print("==============================")

    print(result)


if __name__ == "__main__":

    main()
