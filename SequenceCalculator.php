<?php

class SequenceCalculator {
    private $number;

    public function __construct($number = 0) {
        $this->number = abs($number);
    }

    public function calculateCollatzSequence() {
        $sequence = [];
        $maxValue = $this->number;
        $iterations = 0;
        $current = $this->number;

        while ($current != 1) {
            $sequence[] = $current;
            if ($current % 2 == 0) {
                $current /= 2;
            } else {
                $current = 3 * $current + 1;
            }
            if ($current > $maxValue) {
                $maxValue = $current;
            }
            $iterations++;
        }
        $sequence[] = 1; // Adding the last 1 to the sequence

        return [
            'sequence' => $sequence,
            'maxValue' => $maxValue,
            'iterations' => $iterations
        ];
    }

    public function calculateArithmeticProgression($firstnum, $difference, $n) {
        $progression = [];
        for ($i = 0; $i < $n; $i++) {
            $progression[] = $firstnum + $i * $difference;
        }
        return $progression;
    }

    public function arithProgSum($firstnum, $difference, $n) {
        // Using the formula: Sum = n/2 * (2a + (n - 1)d)
        return $n / 2 * (2 * $firstnum + ($n - 1) * $difference);
    }

    public function arithProgSeries($firstnum, $difference, $n) {
        return $this->calculateArithmeticProgression($firstnum, $difference, $n);
    }
}
class CollatzSequenceStatisticsCalculator extends SequenceCalculator {
    public function calculateCollatzSequenceStatistics($start, $end) {
        $statistics = [];
        for ($i = $start; $i <= $end; $i++) {
            $result = $this->calculateCollatzSequenceStats($i);
            $statistics[$result['iterations']] = isset($statistics[$result['iterations']]) ? $statistics[$result['iterations']] + 1 : 1;
        }
        return $statistics;
    }

    private function calculateCollatzSequenceStats($number) {
        $maxValue = $number;
        $iterations = 0;
        $current = $number;

        while ($current != 1) {
            if ($current % 2 == 0) {
                $current /= 2;
            } else {
                $current = 3 * $current + 1;
            }
            if ($current > $maxValue) {
                $maxValue = $current;
            }
            $iterations++;
        }

        return [
            'iterations' => $iterations,
            'maxValue' => $maxValue
        ];
    }
}
