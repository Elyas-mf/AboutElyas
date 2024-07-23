<?php
include 'db_connect.php';

// Fetch summary counts
$summaryQuery = "SELECT 
    (SELECT COUNT(*) FROM action_log WHERE action_type = 'visit') as total_visits,
    (SELECT COUNT(*) FROM action_log WHERE action_type = 'download') as total_downloads";
$summaryResult = mysqli_query($conn, $summaryQuery);
$summaryCounts = mysqli_fetch_assoc($summaryResult);

$totalVisits = $summaryCounts['total_visits'];
$totalDownloads = $summaryCounts['total_downloads'];
?>

<!-- Display the totals in your dashboard -->
<div id="summary">
    <h3>Total Visits: <?php echo $totalVisits; ?></h3>
    <h3>Total Downloads: <?php echo $totalDownloads; ?></h3>
</div>


