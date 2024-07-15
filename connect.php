<?php
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$conn = new mysqli('localhost', 'root', '', 'contactform');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO contact(name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message); 
    $stmt->execute();
    echo "Thanks, I will contact you soon";
    $stmt->close();
    $conn->close();
}
?>
