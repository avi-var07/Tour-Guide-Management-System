<?php
session_start();
include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $data['user_id'] ?? null;
    $destination = trim($data['destination']);
    $duration = (int)$data['duration'];
    $budget = (float)$data['budget'];
    $services = trim($data['services']);

    if (empty($destination) || $duration <= 0 || $budget <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO custom_tours (user_id, destination, duration, budget, services) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isids", $user_id, $destination, $duration, $budget, $services);

    if ($stmt->execute()) {
        // Send email
        $email = $_SESSION['username'] ?? 'user@example.com';
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom(SMTP_USER, 'Tour Operator');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Custom Tour Request Submitted';
            $mail->Body = "
                <h2>Custom Tour Request Confirmation</h2>
                <p>Dear Customer,</p>
                <p>Your custom tour request has been submitted successfully.</p>
                <p><strong>Details:</strong></p>
                <ul>
                    <li>Destination: $destination</li>
                    <li>Duration: $duration days</li>
                    <li>Budget: ₹$budget</li>
                    <li>Services: $services</li>
                </ul>
                <p>We will get back to you soon with further details.</p>
                <p>Best regards,<br>Tour Operator</p>
            ";

            $mail->send();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => true, 'email_error' => "Email could not be sent: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>