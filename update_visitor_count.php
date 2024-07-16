<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'contactform');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error]));
}

// Check if action is update_visitor_count
if (isset($_POST['action']) && $_POST['action'] === 'update_visitor_count') {
    // Update visitor count in database
    $update_query = "UPDATE visitor_count SET count = count + 1 WHERE id = 1"; // Assuming your table has a single row with ID 1 for visitor count
    $result = $conn->query($update_query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating visitor count']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();
?>
