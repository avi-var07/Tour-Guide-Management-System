<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if (isset($_SESSION['username'])) {
    $email = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT fname, email, phone FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Not logged in']);
}
?>