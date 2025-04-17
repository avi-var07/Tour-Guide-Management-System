<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

try {
    // Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM custom_tours WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $_SESSION['username']);
    
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();
    
    $tours = [];
    while ($row = $result->fetch_assoc()) {
        $tours[] = $row;
    }
    
    echo json_encode($tours);
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo json_encode([]);
}
?>