<?php 
session_start(); 

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // User is not logged in - show message and redirect
    echo "<script>alert('Please login first!'); window.location.href='signup.php';</script>";
    exit; // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Booking Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-image: url('background-travel.jpg'); background-size: cover; background-position: center; }
        .form-container { background: rgba(255, 255, 255, 0.9); border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="text-black">
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
        <div class="flex justify-center items-center min-h-screen">
    <div class="form-container p-8 rounded-lg w-full max-w-lg">
        <h1 class="text-2xl font-bold text-center text-black mb-6">Book A Memory with Us</h1>
        <form method="POST" action="booking.php" name="form" onsubmit="return validateForm()" class="space-y-4">

            <?php
            include 'config.php';

            if (isset($_SESSION['username'])) {
                $email = $_SESSION['username'];
                $sql = "SELECT fname, email, phone, pincode, city, state FROM customer WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    $full_name = $row['fname'];
                    $email = $row['email'];
                    $phone = $row['phone'] ?? '';
                    $pincode = $row['pincode'] ?? '';
                    $city = $row['city'] ?? '';
                    $state = $row['state'] ?? '';
                } else {
                    $full_name = $email = $phone = $pincode = $city = $state = "";
                }
                $stmt->close();
            } else {
                $full_name = $email = $phone = $pincode = $city = $state = "";
            }
            ?>

            <input type="text" name="first_name" value="<?php echo htmlspecialchars($full_name); ?>" placeholder="Full Name" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black" required>
            <input type="text" id="pincode" name="pincode" value="<?php echo htmlspecialchars($pincode); ?>" required maxlength="6" pattern="[0-9]{6}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-green-500 text-black" placeholder="Pincode" onkeyup="fetchLocation()">
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" placeholder="City" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black" readonly required>
            <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($state); ?>" placeholder="State" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black" readonly required>
            <input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>" pattern="[0-9]{10}" maxlength="10" placeholder="Phone" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black" required>
            <input type="text" name="destination" placeholder="Destination" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black" required>
            <input type="text" name="guide" placeholder="Guide Name (Optional)" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black">
            <input type="number" name="amount" value="5000" readonly placeholder="Amount (in INR)" class="w-full p-3 border rounded-lg focus:ring focus:ring-green-300 text-black " required>

            <button type="submit" class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition duration-300">
                Submit
            </button>
        </form>
    </div>
</div>

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
            
         
        <!-- Bottom Section with Copyright -->
        <div >
            <p class="text-gray-400 text-sm">© 2025 Tour Operator. All rights reserved.</p>
            
        </div>
    </div>
</footer>
<script>
    function validateForm() {
        let fullName = document.forms["form"]["first_name"].value.trim();
        let email = document.forms["form"]["email"].value.trim();
        let phone = document.forms["form"]["phone"].value.trim();
        let pincode = document.getElementById("pincode").value.trim();
        let amount = document.forms["form"]["amount"].value.trim();

        if (fullName === "") {
            alert("Full name is required!");
            return false;
        }
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            alert("Please enter a valid email!");
            return false;
        }
        if (!/^\d{10}$/.test(phone)) {
            alert("Phone number must be 10 digits!");
            return false;
        }
        if (!/^\d{6}$/.test(pincode)) {
            alert("Pincode must be 6 digits!");
            return false;
        }
        if (amount !== "5000") {
            alert("Amount cannot be changed!");
            return false;
        }
        return true;
    }

    function fetchLocation() {
        let pincode = document.getElementById("pincode").value;
        let cityField = document.getElementById("city");
        let stateField = document.getElementById("state");

        if (pincode.length === 6) {
            fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                .then(response => response.json())
                .then(data => {
                    if (data[0] && data[0].Status === "Success" && data[0].PostOffice) {
                        cityField.value = data[0].PostOffice[0].District;
                        stateField.value = data[0].PostOffice[0].State;
                    } else {
                        cityField.value = "";
                        stateField.value = "";
                        alert("Invalid Pincode! Please enter a valid one.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching location:", error);
                    cityField.value = "";
                    stateField.value = "";
                    alert("Could not fetch location. Please try again.");
                });
        }
    }
</script>

<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Please login first!'); window.location.href='signup.php';</script>";
        exit;
    }

    $first_name = trim($_POST["first_name"]);
    $email = trim($_POST["email"]);
    $pincode = trim($_POST["pincode"]);
    $city = trim($_POST["city"]);
    $state = trim($_POST["state"]);
    $phone = trim($_POST["phone"]);
    $destination = trim($_POST["destination"]);
    $guide = trim($_POST["guide"] ?? "");
    $amount = trim($_POST["amount"]);

    if (empty($first_name) || empty($email) || empty($pincode) || empty($city) || empty($state) || empty($phone) || empty($destination) || empty($amount)) {
        echo "<script>alert('All required fields must be filled!'); window.history.back();</script>";
        exit;
    }

    // Insert into bookings table with updated column
    $stmt = $conn->prepare("INSERT INTO bookings (first_name, email, pincode, city, state, phone, destination, guide, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $first_name, $email, $pincode, $city, $state, $phone, $destination, $guide, $amount);

    if ($stmt->execute()) {
        // Email configuration
        $to = $email;
        $subject = "Tour Booking Confirmation";
        $message = "Dear $first_name,\n\nThank you for your booking!\n\nHere are your booking details:\n";
        $message .= "Full Name: $first_name\n";
        $message .= "Email: $email\n";
        $message .= "Pincode: $pincode\n";
        $message .= "City: $city\n";
        $message .= "State: $state\n";
        $message .= "Phone: $phone\n";
        $message .= "Destination: $destination\n";
        $message .= "Guide: " . ($guide ? $guide : "Not specified") . "\n";
        $message .= "Amount: ₹$amount\n\n";
        $message .= "Please process the payment using the attached QR code to finalize your booking.\n\nBest regards,\nTour Operator Team";

        // Attachment (QR code image)
        $file = "phonepe_qr-1.png"; // Ensure this file exists and is the uploaded QR code
        $boundary = md5(time());
        $headers = "From: teamTourOperator@gmail.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";

        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $body .= $message . "\r\n";

        $body .= "--" . $boundary . "\r\n";
        $body .= "Content-Type: image/jpeg; name=\"" . basename($file) . "\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"" . basename($file) . "\"\r\n\r\n";
        $body .= chunk_split(base64_encode(file_get_contents($file))) . "\r\n";
        $body .= "--" . $boundary . "--";

        if (mail($to, $subject, $body, $headers)) {
            echo "<script>alert('Confirmation sent to email! Please process payment for final confirmation!'); window.location.href='mainpage.php';</script>";
        } else {
            echo "<script>alert('Booking successful, but email sending failed!'); window.location.href='mainpage.php';</script>";
        }
    } else {
        echo "<script>alert('Error occurred! Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!-- Include the common JavaScript for dropdown and theme toggle -->
<script>
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
