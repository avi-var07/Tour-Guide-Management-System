<?php
include 'config.php';

header('Content-Type: application/json');

$stmt = $conn->prepare("SELECT * FROM packages");
$stmt->execute();
$result = $stmt->get_result();
$packages = [];

while ($row = $result->fetch_assoc()) {
    $packages[] = $row;
}

echo json_encode($packages);

$stmt->close();
$conn->close();
?>