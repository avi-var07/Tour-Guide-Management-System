<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(403);
    exit;
}

$tour_id = $_GET['id'] ?? null;

if (!$tour_id) {
    http_response_code(400);
    exit;
}

try {
    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare SQL statement to check if the tour belongs to the user
    $stmt = $conn->prepare("SELECT username FROM custom_tours WHERE id = ?");
    $stmt->bind_param("i", $tour_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if ($row['username'] != $_SESSION['username']) {
            http_response_code(403);
            exit;
        }
    } else {
        http_response_code(404);
        exit;
    }
    
    // Delete the tour
    $stmt = $conn->prepare("DELETE FROM custom_tours WHERE id = ? AND username = ?");
    $stmt->bind_param("ii", $tour_id, $_SESSION['username']);
    $stmt->execute();
    
    http_response_code(200);
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    http_response_code(500);
}
?>