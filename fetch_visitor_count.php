<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'contactform');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error]));
}

// Fetch visitor count
$result = $conn->query("SELECT count FROM visitor_count WHERE id = 1"); // Assuming your table has a single row with ID 1 for visitor count
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $visitor_count = $row['count'];
    echo json_encode(['success' => true, 'count' => $visitor_count]);
} else {
    echo json_encode(['success' => false, 'message' => 'Visitor count not found']);
}

$conn->close();
?>
