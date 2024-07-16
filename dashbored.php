<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'contactform');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error]));
}

// Check if action is delete
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $delete_id = $_POST['delete_id'];
    
    // Move to archive
    $move_to_archive = $conn->query("INSERT INTO archive_contact SELECT * FROM contact WHERE id='$delete_id'");
    
    if ($move_to_archive) {
        // Delete from contact
        $delete_contact = $conn->query("DELETE FROM contact WHERE id='$delete_id'");
        
        if ($delete_contact) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting from contact']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error moving to archive']);
    }
} else {
    // Fetch all forms
    $result = $conn->query("SELECT * FROM contact");
    if ($result->num_rows > 0) {
        $forms = [];
        while ($row = $result->fetch_assoc()) {
            $forms[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'message' => $row['message']
            ];
        }
        echo json_encode(['success' => true, 'forms' => $forms]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No forms found']);
    }
}

$conn->close();
?>

