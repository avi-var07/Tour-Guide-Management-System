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

// Handle OTP Sending
if (isset($_POST['send_otp'])) {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['pincode'] = $_POST['pincode'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['confirm_password'] = $_POST['confirm_password'];
    $_SESSION['terms'] = isset($_POST['terms']) ? 1 : 0;
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $_SESSION['otp_time'] = time();

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = password_hash($otp, PASSWORD_DEFAULT);

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
        $mail->Subject = "Your OTP for Signup";
        $mail->Body = "Your OTP is: " . $otp;

        $mail->send();
        $_SESSION['otp_sent'] = "OTP sent successfully!";
    } catch (Exception $e) {
        $_SESSION['error'] = "OTP sending failed: " . $mail->ErrorInfo;
    }
}

// Handle Signup
if (isset($_POST['signup'])) {
    if (!isset($_POST['terms'])) {
        $_SESSION['error'] = "You must agree to the Terms and Conditions!";
    }

    $firstname = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $pincode = trim($_POST['pincode']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $otp_entered = $_POST['otp'];

    if (time() - $_SESSION['otp_time'] > 300) {
        $_SESSION['error'] = "OTP expired!";
        header("Location: signup.php");
        exit();
    } elseif (!password_verify($otp_entered, $_SESSION['otp'])) {
        $_SESSION['error'] = "Invalid OTP!";
        header("Location: signup.php");
        exit();
    }

    $_SESSION['name'] = $firstname;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['dob'] = $dob;
    $_SESSION['pincode'] = $pincode;
    $_SESSION['city'] = $city;
    $_SESSION['state'] = $state;
    $_SESSION['password'] = $password;
    $_SESSION['confirm_password'] = $confirm_password;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
    } else {
        $stmt = mysqli_prepare($con, "SELECT * FROM `customer` WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = "Email is already registered!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($con, "INSERT INTO `customer` (fname, email, phone, dob, pincode, city, state, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssssss", $firstname, $email, $phone, $dob, $pincode, $city, $state, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "Signup Successful! Please login.";
                unset($_SESSION['name'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['dob'], $_SESSION['pincode'], $_SESSION['city'], $_SESSION['state'], $_SESSION['password'], $_SESSION['confirm_password']);
                header("Location: signin.php");
                exit();
            } else {
                $_SESSION['error'] = "Signup failed. Please try again!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Tour Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-image: url('background-travel.jpg'); background-size: cover; background-position: center; }
        .form-container { background: rgba(255, 255, 255, 0.95); border-radius: 15px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="text-black">
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
            <li><a href="signup.php" class="hover:text-red-400 bg-blue-500 text-white px-4 py-2 rounded">Login</a></li>
            <?php endif; ?>
          </ul>
        </nav>



<div class="flex justify-center items-center min-h-screen py-10">
    <div class="form-container p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-black mb-6">Create an Account</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='text-red-500 text-center mb-4'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo "<p class='text-green-500 text-center mb-4'>".$_SESSION['success']."</p>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['otp_sent'])) {
            echo "<p class='text-green-500 text-center mb-4'>".$_SESSION['otp_sent']."</p>";
            unset($_SESSION['otp_sent']);
        }
        ?>

        <form action="signup.php" method="POST" onsubmit="return validateTerms()" class="space-y-4">
            <div>
                <label class="block text-black font-semibold">Full Name</label>
                <input type="text" name="name" value="<?= isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black">
            </div>
            <div>
                <label class="block text-black font-semibold">Email</label>
                <input type="email" name="email" value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black">
            </div>
            <div>
                <label class="block text-black font-semibold">Contact Number</label>
                <input type="tel" name="phone" pattern="[0-9]{10}" maxlength="10" value="<?= isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black" placeholder="Enter 10-digit number">
            </div>
            <div>
                <label class="block text-black font-semibold">Date of Birth</label>
                <input type="date" name="dob" value="<?= isset($_SESSION['dob']) ? htmlspecialchars($_SESSION['dob']) : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black">
            </div>
            <div>
                <label class="block text-black font-semibold">Pincode</label>
                <input type="text" id="pincode" name="pincode" required maxlength="6" pattern="[0-9]{6}" value="<?= isset($_SESSION['pincode']) ? htmlspecialchars($_SESSION['pincode']) : ''; ?>" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black" placeholder="Enter Pincode" onkeyup="fetchLocation()">
            </div>
            <div>
                <label class="block text-black font-semibold">City</label>
                <input type="text" id="city" name="city" value="<?= isset($_SESSION['city']) ? htmlspecialchars($_SESSION['city']) : ''; ?>" readonly required class="w-full px-4 py-2 border rounded-lg bg-gray-200 text-black">
            </div>
            <div>
                <label class="block text-black font-semibold">State</label>
                <input type="text" id="state" name="state" value="<?= isset($_SESSION['state']) ? htmlspecialchars($_SESSION['state']) : ''; ?>" readonly required class="w-full px-4 py-2 border rounded-lg bg-gray-200 text-black">
            </div>
            <div>
                <label class="block text-black font-semibold">Password</label>
                <input type="password" name="password" value="<?= isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black">
            </div>
            <div>
                <label class="block text-black font-semibold">Confirm Password</label>
                <input type="password" name="confirm_password" value="<?= isset($_SESSION['confirm_password']) ? htmlspecialchars($_SESSION['confirm_password']) : ''; ?>" required class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black">
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="terms" name="terms" class="mr-2">
                <label for="terms" class="text-black text-sm">I agree to the <a href="terms.php" class="text-green-500 underline">Terms and Conditions</a></label>
            </div>
            <button type="submit" name="send_otp" formnovalidate class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">Send OTP</button>
            <div>
                <label class="block text-black font-semibold">Enter OTP</label>
                <input type="password" name="otp" maxlength="6" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 text-black">
            </div>
            <button type="submit" name="signup" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition duration-300">Sign Up</button>
            <p class="text-center text-black mt-3">Already have an account? <a href="signin.php" class="text-green-500 underline">Login</a></p>
        </form>
    </div>
</div>

<footer class="bg-navy-800 text-white p-4 text-center">
    <p>© 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
</footer>

<script>
function fetchLocation() {
    let pincode = document.getElementById("pincode").value;
    let cityField = document.getElementById("city");
    let stateField = document.getElementById("state");

    if (pincode.length === 6) {
        fetch(`https://api.postalpincode.in/pincode/${pincode}`)
            .then(response => response.json())
            .then(data => {
                if (data[0].Status === "Success") {
                    cityField.value = data[0].PostOffice[0].District;
                    stateField.value = data[0].PostOffice[0].State;
                } else {
                    cityField.value = "";
                    stateField.value = "";
                    alert("Invalid Pincode! Please enter a valid one.");
                }
            })
            .catch(error => console.error("Error fetching location:", error));
    }
}

function validateTerms() {
    if (!document.getElementById("terms").checked) {
        alert("You must agree to the Terms and Conditions to sign up.");
        return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtn = document.getElementById("dropdownBtn");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const userDropdownBtn = document.getElementById("userDropdownBtn");
    const userDropdownMenu = document.getElementById("userDropdownMenu");
    const themeToggleBtn = document.getElementById("themeToggle");
    const body = document.body;

    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle("hidden");
        });
        document.addEventListener("click", function (event) {
            if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });
    }

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
});
</script>
</body>
</html>