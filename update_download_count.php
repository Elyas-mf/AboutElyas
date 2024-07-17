<?php
$conn = new mysqli('localhost', 'root', '', 'contactform');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error]));
}

// Check if action is update_download_count
if (isset($_POST['action']) && $_POST['action'] === 'update_download_count') {

    $update_query = "UPDATE download_counter SET count = count + 1 WHERE id = 1"; 
    $result = $conn->query($update_query);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Download count updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating download count']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

$conn->close();
?>
