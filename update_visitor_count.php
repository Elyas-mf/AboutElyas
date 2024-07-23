<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_visitor_count') {
    // Insert a new row for each visit
    $query = "INSERT INTO action_log (action_type) VALUES ('visit')";
    if (mysqli_query($conn, $query)) {
        // Increment the summary count
        $summaryQuery = "UPDATE summary_counts SET total_count = total_count + 1 WHERE action_type = 'visit'";
        mysqli_query($conn, $summaryQuery);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating visitor count']);
    }
}
?>
