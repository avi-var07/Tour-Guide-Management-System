<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $otp = $data['otp'];
    $newPassword = $data['newPassword'];

    // Verify OTP
    $stmt = $conn->prepare("SELECT otp, created_at FROM otp_verification WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $otp_time = strtotime($row['created_at']);
        if ($row['otp'] === $otp && (time() - $otp_time) <= 600) { // 10-minute validity
            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE customer SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $email);

            if ($stmt->execute()) {
                // Delete OTP
                $stmt = $conn->prepare("DELETE FROM otp_verification WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update password']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid or expired OTP']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'OTP not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>