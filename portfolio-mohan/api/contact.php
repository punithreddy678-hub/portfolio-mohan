<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "portfolio_db";

$conn = new mysqli($host, $user, $password, $dbname);

// CHECK CONNECTION
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SAFELY GET DATA
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// PREVENT EMPTY INSERT
if ($name == '' || $email == '' || $message == '') {
    die("All required fields must be filled!");
}

// SAFE QUERY (IMPORTANT FIX)
$stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    echo "Message sent successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>