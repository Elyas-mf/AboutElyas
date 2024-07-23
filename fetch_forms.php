<?php
include 'db_connect.php';

$sql = "SELECT id, name, email, message FROM contact";  // Adjust the table name and column names as needed
$result = $conn->query($sql);

$forms = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $forms[] = $row;
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'No forms found'));
    exit();
}
echo json_encode(array('success' => true, 'forms' => $forms));

$conn->close();
?>
