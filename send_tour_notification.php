<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendTourRequestNotification($userEmail, $destination, $duration, $budget, $services) {
    // Log attempt to send email
    error_log("Attempting to send tour notification email to: $userEmail");
    
    try {
        // Make sure PHPMailer is available
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            error_log("PHPMailer classes not available - check autoloader");
            return false;
        }
        
        $mail = new PHPMailer(true);
        
        // Server settings - UPDATE THESE WITH YOUR ACTUAL SMTP SETTINGS
        $mail->SMTPDebug = 2; // Enable verbose debugging (only during development)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change to your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com'; // Change to your email
        $mail->Password = 'your-app-password'; // Change to your app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        // Recipients
        $mail->setFrom('noreply@touroperator.com', 'Tour Operator');
        $mail->addAddress($userEmail);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Custom Tour Request Confirmation';
        $mail->Body = "
            <h2>Thank you for your custom tour request!</h2>
            <p>We have received your request for a custom tour package with the following details:</p>
            <ul>
                <li><strong>Destination:</strong> {$destination}</li>
                <li><strong>Duration:</strong> {$duration} days</li>
                <li><strong>Budget:</strong> ₹{$budget}</li>
                <li><strong>Additional Services:</strong> {$services}</li>
            </ul>
            <p>Our team will review your request and get back to you within 24-48 hours with a customized itinerary and pricing.</p>
            <p>If you have any questions, please feel free to contact us.</p>
            <p>Best regards,<br>Tour Operator Team</p>
        ";
        
        $mail->send();
        error_log("Email sent successfully to $userEmail");
        return true;
    } catch (Exception $e) {
        error_log("Mail could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>