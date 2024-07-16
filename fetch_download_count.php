<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'contactform');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error]));
}

// Fetch download count from download_counter table
$result = $conn->query("SELECT count FROM download_counter WHERE id = 1"); // Assuming id 1 for simplicity

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $downloadCount = $row['count'];
    echo json_encode(['success' => true, 'count' => $downloadCount]);
} else {
    echo json_encode(['success' => false, 'message' => 'No download count found']);
}

$conn->close();
?>
