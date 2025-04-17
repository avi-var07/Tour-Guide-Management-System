<?php
session_start();
include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $currentPassword = $data['currentPassword'];

    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($currentPassword, $row['password'])) {
            // Generate OTP
            $otp = rand(100000, 999999);
            $stmt = $conn->prepare("INSERT INTO otp_verification (email, otp) VALUES (?, ?) ON DUPLICATE KEY UPDATE otp = ?, created_at = NOW()");
            $stmt->bind_param("sss", $email, $otp, $otp);
            $stmt->execute();

            // Send OTP via email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom(SMTP_USER, 'Kahan Chale');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Password Change OTP';
                $mail->Body = "<h2>OTP for Password Change</h2><p>Your OTP is: <strong>$otp</strong></p><p>It is valid for 10 minutes.</p>";

                $mail->send();
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => "Email could not be sent: {$mail->ErrorInfo}"]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Incorrect current password']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>