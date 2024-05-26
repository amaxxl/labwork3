<?php
require_once 'SequenceCalculator.php';

function calculate_range($start, $end) {
    $results = [];
    for ($i = $start; $i <= $end; $i++) {
        $calc = new SequenceCalculator($i);
        $results[] = array_merge(['number' => $i], $calc->calculateCollatzSequence());
    }
    return $results;
}
