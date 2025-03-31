<?php
session_start();
header("Content-Type: application/json");

// Database credentials
$host = "localhost";
$user = "root"; 
$password = "";
$dbname = "travel";

// Establish connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Ensure customer ID is set in the session
if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$customer_id = $_SESSION['customer_id']; 

// Fetch customer data
$sql = "SELECT fname, email, phone FROM customer WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Customer not found"]);
}

// Close resources
$stmt->close();
$conn->close();
?>
