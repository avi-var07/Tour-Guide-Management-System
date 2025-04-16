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
<nav class="flex justify-between items-center bg-gradient-to-r from-blue-900 to-indigo-800 py-4 px-6 shadow-lg">
    <a href="mainPage.php" class="text-2xl font-bold text-white tracking-wide flex items-center">
        <span class="text-yellow-400 mr-1">✈️</span> Tour Operator
    </a>
    
    <ul class="flex items-center space-x-6">
        <li><a href="mainPage.php" class="text-white hover:text-yellow-300 transition-colors font-medium">Home</a></li>
        <li><a href="destination.php" class="text-white hover:text-yellow-300 transition-colors font-medium">Destinations</a></li>
        <li><a href="feedback.php" class="text-white hover:text-yellow-300 transition-colors font-medium">Feedback</a></li>
        
        <li class="relative group">
            <button id="dropdownBtn" class="text-white font-medium cursor-pointer focus:outline-none flex items-center hover:text-yellow-300 transition-colors">
                Bookings
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="dropdownMenu" class="absolute hidden bg-white text-gray-800 shadow-xl rounded-lg mt-2 w-64 z-50 py-2 border border-gray-100 group-hover:block transform origin-top">
                <li><a href="guidebooking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">👤</span> Hire a Guide</a></li>
                <li><a href="booking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">🏞️</span> Tour Booking</a></li>
                <li><a href="userDashboard.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">📊</span> User Dashboard</a></li>
                <li><a href="packageManagement.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">📦</span> Tour Package Management</a></li>
                <li><a href="customTour.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">✏️</span> Custom Tour Planning</a></li>
            </ul>
        </li>
        <li><a href="about.php" class="text-white hover:text-yellow-300 transition-colors font-medium">About</a></li>
        
        <li>
            <button id="themeToggle" class="ml-4 bg-blue-700 hover:bg-blue-600 text-white p-2 rounded-full transition-colors focus:ring-2 focus:ring-yellow-300 focus:outline-none">
                <img src="theme_icon.png" alt="Theme Toggle" class="h-5 w-5">
            </button>
        </li>
        
        <?php if (isset($_SESSION['username'])): ?>
        <li class="relative group ml-4">
            <button id="userDropdownBtn" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-colors flex items-center">
                <span class="mr-1">👤</span>
                <?php echo $_SESSION['username']; ?>
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="userDropdownMenu" class="absolute hidden right-0 bg-white text-gray-800 shadow-xl rounded-lg mt-2 w-48 z-50 py-2 border border-gray-100 group-hover:block">
                <li><a href="userDashboard.php" class="block px-4 py-2 hover:bg-blue-50">My Profile</a></li>
                <li><a href="booking.php" class="block px-4 py-2 hover:bg-blue-50">My Bookings</a></li>
                <li><hr class="my-1 border-gray-200"></li>
                <li><a href="logout.php" class="block px-4 py-2 hover:bg-red-50 text-red-600 font-medium">Logout</a></li>
            </ul>
        </li>
        <?php else: ?>
        <li class="ml-4">
            <a href="signup.php" class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-5 py-2 rounded-full transition-colors shadow-md hover:shadow-lg">
                Login / Sign Up
            </a>
        </li>
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
    <footer class="bg-gradient-to-b from-gray-800 to-gray-900 text-white pt-12 pb-6">
    <div class="container mx-auto px-4">
        <!-- Top Section with Logo and Quick Links -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10">
            <div class="flex items-center mb-6 md:mb-0">
                <span class="text-2xl font-bold text-white mr-2">✈️</span>
                <h2 class="text-2xl font-bold">Tour<span class="text-yellow-400">Operator</span></h2>
            </div>
            
            <div class="flex space-x-4">
                <a href="https://www.instagram.com/S_iddharth73" target="_blank" class="bg-gray-700 hover:bg-pink-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fab fa-instagram text-white"></i>
                </a>
                <a href="https://x.com/" target="_blank" class="bg-gray-700 hover:bg-blue-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fab fa-twitter text-white"></i>
                </a>
                <a href="mailto:aviralvarshney07@gmail.com" class="bg-gray-700 hover:bg-yellow-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fas fa-envelope text-white"></i>
                </a>
                <a href="#" class="bg-gray-700 hover:bg-blue-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fab fa-facebook text-white"></i>
                </a>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="border-b border-gray-700 mb-8"></div>
        
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Explore Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-compass text-white"></i>
                    </span>
                    Explore
                </h3>
                <ul class="space-y-3">
                    <li><a href="mainPage.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Home
                    </a></li>
                    <li><a href="destination.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Destinations
                    </a></li>
                    <li><a href="guidebooking.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Hire a Guide
                    </a></li>
                    <li><a href="booking.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Tour Booking
                    </a></li>
                    <li><a href="customTour.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Custom Tour Planning
                    </a></li>
                </ul>
            </div>
            
            <!-- Account Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-green-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-user text-white"></i>
                    </span>
                    Account
                </h3>
                <ul class="space-y-3">
                    <li><a href="userDashboard.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>User Dashboard
                    </a></li>
                    <li><a href="packageManagement.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Package Management
                    </a></li>
                    <li><a href="feedback.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Feedback
                    </a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="logout.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Logout
                        </a></li>
                    <?php else: ?>
                        <li><a href="signup.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                            <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Login
                        </a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Contact Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-yellow-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-phone text-white"></i>
                    </span>
                    Contact
                </h3>
                <ul class="space-y-3">
                    <li class="text-gray-300 flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-yellow-400"></i>
                        <span>Tour Operator | Jalandhar, Punjab</span>
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-envelope mr-3 text-yellow-400"></i>
                        <a href="mailto:aviralvarshney07@gmail.com" class="hover:text-yellow-400 transition-colors duration-200">teamTourOperator@gmail.com</a>
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-phone-alt mr-3 text-yellow-400"></i>
                        <span>+91 9876543210</span>
                    </li>
                    <li class="text-gray-300 flex items-center">
                    <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>
                        <span><a href="about.php">About Us</a></span>
                    </li>
                </ul>
            </div>
            
            <!-- Newsletter Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-purple-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-envelope-open text-white"></i>
                    </span>
                    Newsletter
                </h3>
                <p class="text-gray-300 mb-4">Subscribe to our newsletter for exclusive travel deals and updates.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email address" class="bg-gray-700 text-white px-4 py-2 rounded-l-lg focus:outline-none flex-grow">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-r-lg transition-colors duration-200">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Bottom Section with Copyright -->
        <div class="mt-12 pt-6 border-t border-gray-700 text-center">
            <p class="text-gray-400 text-sm">© 2025 Tour Operator. All rights reserved.</p>
            
        </div>
    </div>
</footer>
</body>
</html>