<?php
session_start();
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'config.php'; // Use require_once to avoid redefinition

// Database Connection
$con = mysqli_connect('localhost', 'root', '', 'travel', 3306);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$message_class = "";

// Handle OTP Sending
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['email']);
    
    // Check if email exists in database
    $stmt = mysqli_prepare($con, "SELECT * FROM `customer` WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Email exists, generate and send OTP
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_otp_time'] = time();

        $otp = rand(100000, 999999);
        $_SESSION['reset_otp'] = password_hash($otp, PASSWORD_DEFAULT);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(SMTP_USER, 'Tour Operator');
            $mail->addAddress($email);
            $mail->Subject = "Password Reset OTP";
            $mail->Body = "Your OTP for password reset is: " . $otp . "\nThis OTP will expire in 5 minutes.";

            $mail->send();
            $message = "OTP sent successfully to your email!";
            $message_class = "text-green-500";
        } catch (Exception $e) {
            $message = "OTP sending failed: " . $mail->ErrorInfo;
            $message_class = "text-red-500";
        }
    } else {
        $message = "Email not found in our records!";
        $message_class = "text-red-500";
    }
}

// Handle Reset Password
if (isset($_POST['reset_password'])) {
    $email = $_SESSION['reset_email'] ?? '';
    $otp_entered = trim($_POST['otp']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if OTP is expired (5 minutes)
    if (time() - $_SESSION['reset_otp_time'] > 300) {
        $message = "OTP expired! Please request a new one.";
        $message_class = "text-red-500";
    } 
    // Verify OTP
    elseif (!password_verify($otp_entered, $_SESSION['reset_otp'])) {
        $message = "Invalid OTP! Please try again.";
        $message_class = "text-red-500";
    } 
    // Check password match
    elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match!";
        $message_class = "text-red-500";
    } 
    // All good, update password
    else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($con, "UPDATE `customer` SET password=? WHERE email=?");
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Password reset successful! You can now login with your new password.";
            $message_class = "text-green-500";
            
            // Clear reset session variables
            unset($_SESSION['reset_email'], $_SESSION['reset_otp'], $_SESSION['reset_otp_time']);
            
            // Redirect to login page after 3 seconds
            header("refresh:3;url=signin.php");
        } else {
            $message = "Password reset failed! Please try again.";
            $message_class = "text-red-500";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Tour Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<nav class="flex justify-between items-center bg-gray-800 p-4">
    <a href="mainPage.php" class="text-xl font-bold text-blue-400">Tour Operator</a>
    <ul class="flex space-x-4 relative items-center">
        <li><a href="mainPage.php" class="hover:text-yellow-400 text-blue-400">Home</a></li>
        <li><a href="destination.php" class="hover:text-yellow-400 text-blue-400">Destination</a></li>
        <li><a href="feedback.php" class="hover:text-yellow-400 text-blue-400">Feedback</a></li>
        
        <li class="relative">
            <button id="dropdownBtn" class="text-blue-400 cursor-pointer focus:outline-none flex items-center hover:text-yellow-400">
                Bookings
                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="dropdownMenu" class="absolute hidden bg-gray-800 shadow-lg rounded-md mt-2 w-60 z-50">
                <li><a href="guidebooking.php" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Hire a Guide</a></li>
                <li><a href="booking.php" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Tour Booking</a></li>
                <li><a href="userDashboard.php" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">User Dashboard</a></li>
                <li><a href="packageManagement.php" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Tour Package Management</a></li>
                <li><a href="customTour.php" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Custom Tour Planning</a></li>
            </ul>
        </li>
        <li><a href="about.php" class="hover:text-yellow-400 text-blue-400">About</a></li>
        <button id="themeToggle" class="ml-4 bg-gray-700 text-white px-4 py-2 rounded-md text-blue-400">
          <img src="theme_icon.png" alt="Theme Toggle" height="20px" width="20px">
        </button>
        <?php if (isset($_SESSION['username'])): ?>
          <li class="relative">
            <button id="userDropdownBtn" class="text-blue-400 cursor-pointer focus:outline-none flex items-center hover:text-yellow-400">
              <?php echo $_SESSION['username']; ?>
              <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </button>
            <ul id="userDropdownMenu" class="absolute hidden bg-gray-800 shadow-lg rounded-md mt-2 w-48 z-50">
              <li><a href="logout.php" class="block px-4 py-2 hover:bg-gray-700 text-red-400">Logout</a></li>
            </ul>
          </li>
          <?php else: ?>
            <li><a href="signin.php" class="hover:text-red-400 bg-blue-500 text-white px-4 py-2 rounded">Login</a></li>
            <?php endif; ?>
          </ul>
        </nav>

    <div class="bg-white p-6 rounded-lg shadow-lg w-[400px] flexbox justify-center items-center mt-20 mx-auto">
        <fieldset class="border border-gray-300 p-4 rounded-lg">
            <legend class="text-xl font-bold text-gray-700 px-2">Forgot Password</legend>

            <?php if (!empty($message)): ?>
                <div class="my-4 <?php echo $message_class; ?> text-center"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if (!isset($_SESSION['reset_otp'])): ?>
            <!-- Step 1: Email Form -->
            <form action="forgot_password.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" placeholder="Enter your registered email">
                </div>
                <button type="submit" name="send_otp" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Send Reset OTP</button>
            </form>
            <?php else: ?>
            <!-- Step 2: OTP and New Password Form -->
            <form action="forgot_password.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Enter OTP</label>
                    <input type="text" name="otp" required maxlength="6" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" placeholder="Enter the 6-digit OTP">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">New Password</label>
                    <input type="password" name="new_password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" placeholder="Enter new password">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Confirm New Password</label>
                    <input type="password" name="confirm_password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" placeholder="Confirm new password">
                </div>
                <button type="submit" name="reset_password" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">Reset Password</button>
            </form>
            <?php endif; ?>
            
            <p class="mt-4 text-center text-gray-600">
                Remember your password? <a href="signin.php" class="text-blue-500">Sign In</a>
            </p>
        </fieldset>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
    // Bookings dropdown toggle
    const dropdownBtn = document.getElementById("dropdownBtn");
    const dropdownMenu = document.getElementById("dropdownMenu");

    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener("click", function () {
            dropdownMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });
    }

    // Theme toggle
    const themeToggleBtn = document.getElementById("themeToggle");
    const body = document.body;

    if (themeToggleBtn) {
        const savedTheme = localStorage.getItem("theme") || "dark";
        body.classList.toggle("bg-gray-100", savedTheme === "light");
        body.classList.toggle("bg-gray-900", savedTheme === "dark");
        body.classList.toggle("text-black", savedTheme === "light");
        body.classList.toggle("text-white", savedTheme === "dark");

        themeToggleBtn.addEventListener("click", function () {
            const newTheme = body.classList.contains("bg-gray-900") ? "light" : "dark";

            body.classList.toggle("bg-gray-100", newTheme === "light");
            body.classList.toggle("bg-gray-900", newTheme === "dark");
            body.classList.toggle("text-black", newTheme === "light");
            body.classList.toggle("text-white", newTheme === "dark");

            localStorage.setItem("theme", newTheme);
        });
    }

    // User dropdown toggle
    const userDropdownBtn = document.getElementById("userDropdownBtn");
    const userDropdownMenu = document.getElementById("userDropdownMenu");

    if (userDropdownBtn && userDropdownMenu) {
        userDropdownBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            userDropdownMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!userDropdownMenu.contains(event.target) && !userDropdownBtn.contains(event.target)) {
                userDropdownMenu.classList.add("hidden");
            }
        });
    }
});
    </script>
    <footer class="text-center mt-8 py-4 bg-gray-700 text-white fixed bottom-0 w-full">
    <p>&copy; 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
  </footer>
</body>
</html>