<?php
session_start();
require 'config.php'; 
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if this is an AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        echo json_encode(['success' => false, 'error' => 'User not logged in']);
        exit;
    }
    
    // Get JSON data from request
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    // Validate input
    if (empty($data['destination']) || empty($data['duration']) || empty($data['budget'])) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }
    
    try {
        // Connect to database
        $conn = new mysqli($servername, $username, $password, $dbname, $port);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Use username (email) directly from session
        $userEmail = $_SESSION['username'];
        
        // Insert tour request in database using email instead of user_id
        $stmt = $conn->prepare("INSERT INTO custom_tours (user_id, destination, duration, budget, services) VALUES ((SELECT id FROM customer WHERE email = ?), ?, ?, ?, ?)");
        $stmt->bind_param("sisds", $userEmail, $data['destination'], $data['duration'], $data['budget'], $data['services']);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to save tour request");
        }
        
        // Send confirmation email
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER; // Using constant from config.php
            $mail->Password = SMTP_PASS; // Using constant from config.php
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            // Recipients
            $mail->setFrom(SMTP_USER, 'Kahan Chale');
            $mail->addAddress($userEmail, $_SESSION['username'] ?? 'User');
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Custom Tour Request Confirmation';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; color: #333;'>
                    <div style='background-color: #2563eb; color: white; padding: 20px; text-align: center;'>
                        <h1>Your Custom Tour Request</h1>
                    </div>
                    <div style='padding: 20px; border: 1px solid #e5e7eb; border-top: none;'>
                        <h2>Thank you for your custom tour request!</h2>
                        <p>We have received your request with the following details:</p>
                        <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                            <tr style='background-color: #f3f4f6;'>
                                <th style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>Destination</th>
                                <td style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>{$data['destination']}</td>
                            </tr>
                            <tr>
                                <th style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>Duration</th>
                                <td style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>{$data['duration']} days</td>
                            </tr>
                            <tr style='background-color: #f3f4f6;'>
                                <th style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>Budget</th>
                                <td style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>₹{$data['budget']}</td>
                            </tr>
                            <tr>
                                <th style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>Additional Services</th>
                                <td style='padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb;'>{$data['services']}</td>
                            </tr>
                        </table>
                        <p>Our team will review your request and get back to you within 24-48 hours with a personalized itinerary and pricing options.</p>
                        <p>If you have any questions, please contact us at:</p>
                        <p>📧 <a href='mailto:aviralvarshney07@gmail.com'>teamKahanChale@gmail.com</a><br>
                        📞 +91 9876543210</p>
                        <p>Thank you for choosing Kahan Chale for your travel needs!</p>
                        <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280;'>
                            <p>© 2025 Kahan Chale. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            ";
            
            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Tour request submitted and confirmation email sent!']);
        } catch (Exception $e) {
            // Email failed but database entry was successful
            echo json_encode([
                'success' => true, 
                'message' => 'Tour request submitted but email could not be sent',
                'error' => $mail->ErrorInfo
            ]);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    
    exit;
}

// If it's not an AJAX request, redirect to the custom tour page
header("Location: customTour.php");
exit;
?>