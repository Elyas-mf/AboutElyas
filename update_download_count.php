<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_download_count') {
    // Insert a new row for each CV download
    $query = "INSERT INTO action_log (action_type) VALUES ('download')";
    if (mysqli_query($conn, $query)) {
        // Increment the summary count
        $summaryQuery = "UPDATE summary_counts SET total_count = total_count + 1 WHERE action_type = 'download'";
        mysqli_query($conn, $summaryQuery);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating download count']);
    }
}
?>
