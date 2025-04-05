<?php
header('Content-Type: application/json');
include 'db.php'; 

$timeFilter = isset($_GET['time_filter']) ? $_GET['time_filter'] : 'daily';

// Define grouping based on time filter
switch ($timeFilter) {
    case 'daily':
        $groupBy = "DATE(date)";
        break;
    case 'weekly':
        $groupBy = "YEARWEEK(date)";
        break;
    case 'monthly':
        $groupBy = "DATE_FORMAT(date, '%Y-%m')";
        break;
    case 'yearly':
        $groupBy = "YEAR(date)";
        break;
    default:
        $groupBy = "DATE(date)";
}

// Query for trend graph (average scores)
$sqlTrend = "SELECT $groupBy AS period, AVG(score) AS avg_score FROM quiz_responses GROUP BY period ORDER BY period ASC";
$resultTrend = $conn->query($sqlTrend);

$trendData = [];
while ($row = $resultTrend->fetch_assoc()) {
    $trendData['labels'][] = $row['period'];
    $trendData['scores'][] = $row['avg_score'];
}

// Query for most recent mood score
$sqlLatest = "SELECT score FROM quiz_responses ORDER BY date DESC LIMIT 1";
$resultLatest = $conn->query($sqlLatest);
$latestScore = $resultLatest->fetch_assoc();

// Prepare final JSON response
$data = [
    'trend' => $trendData,
    'latest_score' => $latestScore ? $latestScore['score'] : null
];

echo json_encode($data);
?>
