<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$query = $user_id ? "SELECT * FROM custom_tours WHERE user_id = ?" : "SELECT * FROM custom_tours";
$stmt = $conn->prepare($query);

if ($user_id) {
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
$tours = [];

while ($row = $result->fetch_assoc()) {
    $tours[] = $row;
}

echo json_encode($tours);

$stmt->close();
$conn->close();
?>