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

            <button type="submit" class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition duration-300">
                Submit
            </button>
        </form>
    </div>
</div>

<footer class="bg-gray-700 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Navigation Links -->
            <div>
                <h3 class="text-lg font-semibold text-blue-400 mb-4">Explore</h3>
                <ul class="space-y-2">
                    <li><a href="mainPage.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-home mr-2"></i>Home</a></li>
                    <li><a href="destination.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-map-marker-alt mr-2"></i>Destinations</a></li>
                    <li><a href="guidebooking.php" class="hover:text-yellow-400 text-gray-300"><i class="fa-solid fa-user-tie"></i>Hire a Guide</a></li>
                    <li><a href="booking.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-ticket-alt mr-2"></i>Tour Booking</a></li>
                    <li><a href="customTour.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-map mr-2"></i>Custom Tour Planning</a></li>
                </ul>
            </div>
            <!-- Account Links -->
            <div>
                <h3 class="text-lg font-semibold text-blue-400 mb-4">Account</h3>
                <ul class="space-y-2">
                    <li><a href="userDashboard.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-user mr-2"></i>User Dashboard</a></li>
                    <li><a href="packageManagement.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-suitcase mr-2"></i>Tour Package Management</a></li>
                    <li><a href="feedback.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-comment mr-2"></i>Feedback</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="logout.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
                    <?php else: ?>
                        <li><a href="signup.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-sign-in-alt mr-2"></i>Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- Social Media & Contact -->
            <div>
                <h3 class="text-lg font-semibold text-blue-400 mb-4">Connect With Us</h3>
                <ul class="space-y-2">
                    <li><a href="about.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-info-circle mr-2"></i>About Us</a></li>
                    <li><a href="https://www.instagram.com/S_iddharth73" target="_blank" class="hover:text-pink-400 text-gray-300"><i class="fab fa-instagram mr-2"></i>Instagram</a></li>
                    <li><a href="https://x.com/" target="_blank" class="hover:text-blue-400 text-gray-300"><i class="fab fa-twitter mr-2"></i>X</a></li>
                    <li><a href="mailto:aviralvarshney07@gmail.com" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-envelope mr-2"></i>Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 text-center border-t border-gray-600 pt-4">
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
    $guide = trim($_POST["guide"] ?? ""); // Optional guide field

    if (empty($first_name) || empty($email) || empty($pincode) || empty($city) || empty($state) || empty($phone) || empty($destination)) {
        echo "<script>alert('All required fields must be filled!'); window.history.back();</script>";
        exit;
    }

    // Insert into bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (first_name, email, pincode, city, state, phone, destination, guide) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $first_name, $email, $pincode, $city, $state, $phone, $destination, $guide);

    if ($stmt->execute()) {
        echo "<script>alert('Booking Successful!'); window.location.href='mainpage.php';</script>";
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