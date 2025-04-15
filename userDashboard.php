<?php
session_start();
include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    
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
 
        <div class="max-w-4xl mx-auto mt-10 bg-gray-800 p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">User Dashboard</h2>

    <!-- Profile Image Section -->
    <div class="flex items-center space-x-4">
        <div id="profileImage" class="w-24 h-24 flex items-center justify-center rounded-full bg-gray-700 text-white text-3xl font-bold"></div>
        <input type="file" id="imageUpload" accept="image/*" class="hidden">
        <button onclick="document.getElementById('imageUpload').click()" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">Upload Image</button>
    </div>

    <!-- Default Avatars -->
    <h3 class="mt-6 text-lg font-semibold">Choose a Default Avatar</h3>
    <div class="flex space-x-4 mt-2">
        <img src="avatars/avatar1.png" class="w-16 h-16 rounded-full cursor-pointer border-2 border-transparent hover:border-yellow-500" onclick="setProfileImage(this.src)">
        <img src="avatars/avatar2.png" class="w-16 h-16 rounded-full cursor-pointer border-2 border-transparent hover:border-yellow-500" onclick="setProfileImage(this.src)">
    </div>

    <!-- Profile Form -->
    <form id="profileForm" class="space-y-4 mt-6">
        <div>
            <label class="block text-sm font-medium text-gray-400">Full Name</label>
            <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600" readonly>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400">Phone Number</label>
            <input type="text" id="phone" name="phone" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400">Current Password</label>
            <input type="password" id="currentPassword" name="currentPassword" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400">New Password</label>
            <input type="password" id="newPassword" name="newPassword" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400">Retype New Password</label>
            <input type="password" id="retypePassword" name="retypePassword" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
        </div>
        <div id="otpSection" class="hidden">
            <label class="block text-sm font-medium text-gray-400">Enter OTP</label>
            <input type="text" id="otp" name="otp" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
            <button type="button" onclick="verifyOTP()" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600 mt-2">Verify OTP</button>
        </div>
        <button type="submit" class="w-full bg-yellow-500 text-black px-4 py-2 rounded-lg hover:bg-yellow-600">Update Profile</button>
    </form>

    <!-- Manage Bookings Section -->
    <div class="mt-6">
        <h3 class="text-xl font-bold mb-4">New Booking</h3>
        <a href="booking.php" class="block bg-blue-500 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-600">View My Bookings</a>
    </div>
    <h2 class="text-2xl font-semibold mt-6">Booking & Feedback History</h2>
    <div class="mt-4 bg-gray-700 p-4 rounded-lg">
        <h3 class="text-lg font-semibold">Past Bookings</h3>
        <ul id="userBookings" class="list-disc ml-5 text-gray-300">
            <li class="text-gray-400">Log in to get history</li>
        </ul>
        <h3 class="text-lg font-semibold mt-4">Guide Hire History</h3>
        <ul id="guideHistory" class="list-disc ml-5 text-gray-300">
            <li class="text-gray-400">Log in to get history</li>
        </ul>
        <h3 class="text-lg font-semibold mt-4">Feedback Given</h3>
        <ul id="userFeedback" class="list-disc ml-5 text-gray-300">
            <li class="text-gray-400">Log in to get history</li>
        </ul>
    </div>
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

<?php if (isset($_SESSION['username'])): ?>
        fetch('fetch_customer.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Error:", data.error);
                } else {
                    document.getElementById('fullName').value = data.fname || '';
                    document.getElementById('email').value = data.email || '';
                    document.getElementById('phone').value = data.phone || '';
                    document.getElementById('profileImage').innerHTML = data.fname ? data.fname.charAt(0).toUpperCase() : '?';
                }
            })
            .catch(error => console.error('Error fetching user data:', error));
    <?php endif; ?>

    // Profile form submission
    document.getElementById("profileForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const currentPassword = formData.get('currentPassword');
        const newPassword = formData.get('newPassword');
        const retypePassword = formData.get('retypePassword');

        if (newPassword || retypePassword) {
            if (newPassword !== retypePassword) {
                alert("New passwords do not match!");
                return;
            }
            if (!currentPassword) {
                alert("Current password is required to change password!");
                return;
            }
            // Initiate OTP for password change
            fetch('send_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: '<?php echo $_SESSION['username']; ?>', currentPassword })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('otpSection').classList.remove('hidden');
                    alert("OTP sent to your email!");
                } else {
                    alert("Error: " + data.error);
                }
            });
        } else {
            // Update profile without password change
            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            });
        }
    });

    // Verify OTP
    window.verifyOTP = function () {
        const otp = document.getElementById('otp').value;
        const newPassword = document.getElementById('newPassword').value;
        fetch('verify_otp.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: '<?php echo $_SESSION['username']; ?>', otp, newPassword })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Password updated successfully!");
                document.getElementById('otpSection').classList.add('hidden');
                document.getElementById('profileForm').reset();
                fetchUserData();
            } else {
                alert("Error: " + data.error);
            }
        });
    };
</script>


    <!-- JavaScript for Profile Image & Avatar Selection -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let fullNameInput = document.getElementById("fullName");
            let profileImage = document.getElementById("profileImage");

            // Function to update default profile image
            function updateProfileImage() {
                let username = fullNameInput.value.trim();
                if (username.length > 0) {
                    profileImage.innerHTML = username.charAt(0).toUpperCase();
                    profileImage.style.backgroundImage = "none"; // Remove any uploaded image
                } else {
                    profileImage.innerHTML = "?";
                }
            }

            // Set default profile image based on username
            fullNameInput.addEventListener("input", updateProfileImage);
            updateProfileImage(); // Run on page load

            // Handle Image Upload
            document.getElementById("imageUpload").addEventListener("change", function(event) {
                let file = event.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        profileImage.style.backgroundImage = `url(${e.target.result})`;
                        profileImage.style.backgroundSize = "cover";
                        profileImage.style.backgroundPosition = "center";
                        profileImage.innerHTML = ""; // Remove text
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle Avatar Selection
            window.setProfileImage = function(src) {
                profileImage.style.backgroundImage = `url(${src})`;
                profileImage.style.backgroundSize = "cover";
                profileImage.style.backgroundPosition = "center";
                profileImage.innerHTML = ""; // Remove text
            };

            // Handle Form Submission
            document.getElementById("profileForm").addEventListener("submit", function(event) {
                event.preventDefault();
                alert("Profile updated successfully! (Backend integration required)");
            });
        });
    </script>

    <!-- Footer -->
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
</body>
</html>