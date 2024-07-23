<?php
include 'db_connect.php';

// Fetch summary counts
$summaryQuery = "SELECT * FROM summary_counts";
$summaryResult = mysqli_query($conn, $summaryQuery);
$summaryCounts = [];
while ($row = mysqli_fetch_assoc($summaryResult)) {
    $summaryCounts[$row['action_type']] = $row['total_count'];
}

$totalVisits = $summaryCounts['visit'] ?? 0;
$totalDownloads = $summaryCounts['download'] ?? 0;

// Output the totals
echo json_encode([
    'success' => true,
    'total_visits' => $totalVisits,
    'total_downloads' => $totalDownloads
]);
?>
