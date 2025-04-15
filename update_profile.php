<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName']);
    $phone = trim($_POST['phone']);
    $email = $_SESSION['username'];

    $stmt = $conn->prepare("UPDATE customer SET fname = ?, phone = ? WHERE email = ?");
    $stmt->bind_param("sss", $fullName, $phone, $email);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>