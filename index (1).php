<?php
require_once 'SequenceCalculator.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>3x + 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="number"], input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .results {
            margin-top: 20px;
        }
        .histogram {
            margin-top: 20px;
            height: 400px; /* Adjust the height as needed */
            white-space: nowrap; /* Prevent line breaks */
            overflow-x: auto; /* Enable horizontal scrolling if necessary */
        }
        .bar {
            display: inline-block;
            width: 40px;
            background-color: #4CAF50;
            margin-right: 2px;
            vertical-align: bottom;
            text-align: center;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Part 1</h1>
    <form action="./" method="GET">
        <input type="number" name="part1" placeholder="Enter a positive number" required />
        <input type="submit" name="submit_part1" value="Submit" />
    </form>

    <?php
    if (isset($_GET["submit_part1"])) {
        $part1 = $_GET["part1"];
        $calculator = new SequenceCalculator($part1);

        if ($part1 >= 1) {
            $result = $calculator->calculateCollatzSequence();
            echo "<div class='results'>";
            echo "<p><strong>Sequence:</strong> " . implode(", ", $result['sequence']) . "</p>";
            echo "<p><strong>Maximum Number:</strong> " . $result['maxValue'] . "</p>";
            echo "<p><strong>Number of Iterations:</strong> " . $result['iterations'] . "</p>";
            echo "</div>";
        }
    }
    ?>

    <h1>Part 2</h1>
    <form action="./" method="GET">
        <input type="number" name="first_num" placeholder="Start Number" required />
        <input type="number" name="second_num" placeholder="End Number" required />
        <input type="submit" name="num_submit" value="Submit" />
    </form>

<?php
    if (isset($_GET["num_submit"])) {
        $first_num = $_GET["first_num"];
        $second_num = $_GET["second_num"];

        if ($first_num >= 1 && $second_num >= 1 && $second_num > $first_num) {
            $results = calculate_range($first_num, $second_num);
            $maxIterations = 0;
            $minIterations = PHP_INT_MAX;
            $maxIterNum = $minIterNum = null;
            $maxValue = $minValue = 0;

            foreach ($results as $result) {
                if ($result['iterations'] > $maxIterations) {
                    $maxIterations = $result['iterations'];
                    $maxIterNum = $result['number'];
                    $maxValue = $result['maxValue'];
                }
                if ($result['iterations'] < $minIterations) {
                    $minIterations = $result['iterations'];
                    $minIterNum = $result['number'];
                    $minValue = $result['maxValue'];
                }
            }
            echo "<div class='results'>
                <h3>Results:</h3>
                <table>
                    <tr>
                        <th>Number</th>
                        <th>Maximum Number</th>
                        <th>Iterations</th>
                    </tr>";
            foreach ($results as $result) {
                echo "<tr>
                        <td>{$result['number']}</td>
                        <td>{$result['maxValue']}</td>
                        <td>{$result['iterations']}</td>
                    </tr>";
            }
            echo "</table>
                </div>";
            echo "<p><strong>Number with Maximum Iterations:</strong> {$maxIterNum} (Iterations: {$maxIterations}, Max Value: {$maxValue})</p>";
            echo "<p><strong>Number with Minimum Iterations:</strong> {$minIterNum} (Iterations: {$minIterations}, Max Value: {$minValue})</p>";

            // Display histogram
            $dataArr = array_column($results, 'iterations');
            $histogram = array_count_values($dataArr);
            ksort($histogram);
            echo "<h3>Histogram</h3>
            <div class='histogram'>";
			foreach ($histogram as $hisIndex => $hisValue) {
				echo "<div class='bar' style='height: " . $hisValue * 10 . "px;' title='x:{$hisIndex}, y:{$hisValue}'><small>{$hisIndex}:{$hisValue}</small></div>";
			}
		} else {
            echo "<p>Please enter a valid range with the end number greater than the start number.</p>";
        }
    }
    ?>

    <h1>Part 3</h1>
    <form action="./" method="GET">
        <input type="number" name="fstnum" placeholder="Add First Term" required />
        <input type="number" name="commDiff" placeholder="Add Common Difference" required />
        <input type="number" name="secnum" placeholder="Add Number of Terms" required />
        <input type="submit" name="calcAP" value="Submit" />
    </form>

<?php
if (isset($_GET["calcAP"])) {
	$fstnum = $_GET["fstnum"];
	$commDiff = $_GET["commDiff"];
	$secnum = $_GET["secnum"];
	$calculator = new SequenceCalculator(); // No specific number required for AP

	$apSum = $calculator->arithProgSum($fstnum, $commDiff, $secnum);
	$apSeries = $calculator->arithProgSeries($fstnum, $commDiff, $secnum);

	echo "<div class='results'>";
	echo "<p><strong>Sum of Arithmetic Progression:</strong> " . $apSum . "</p>";
	echo "<p><strong>Arithmetic Progression Series:</strong></p>";
	echo "<p>" . implode(", ", $apSeries) . "</p>";
	echo "</div>";
}
?>

</body>
</html>
