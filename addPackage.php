<?php
session_start();
include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $packageName = trim($_POST['packageName']);
    $destination = trim($_POST['destination']);
    $price = (float)$_POST['price'];
    $duration = (int)$_POST['duration'];

    if (empty($packageName) || empty($destination) || $price <= 0 || $duration <= 0) {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO packages (name, destination, price, duration) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $packageName, $destination, $price, $duration);

    if ($stmt->execute()) {
        $packageId = $conn->insert_id;

        // Send confirmation email
        $email = $_SESSION['username'] ?? 'user@example.com';
        $mail = new PHPMailer(true);
        try {
            // SMTP settings (replace with your own)
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
            $mail->Subject = 'New Package Added';
            $mail->Body = "
                <h2>New Package Added</h2>
                <p>Dear Customer,</p>
                <p>A new tour package has been successfully added:</p>
                <ul>
                    <li><strong>Name:</strong> $packageName</li>
                    <li><strong>Destination:</strong> $destination</li>
                    <li><strong>Price:</strong> ₹$price</li>
                    <li><strong>Duration:</strong> $duration days</li>
                </ul>
                <p>Thank you for using our services!</p>
                <p>Best regards,<br>Tour Operator</p>
            ";

            $mail->send();
            echo json_encode(['success' => true, 'packageId' => $packageId]);
        } catch (Exception $e) {
            echo json_encode(['success' => true, 'packageId' => $packageId, 'email_error' => "Email could not be sent: {$mail->ErrorInfo}"]);
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