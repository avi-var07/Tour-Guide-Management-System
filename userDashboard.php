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
    
<nav class="flex justify-between items-center bg-gradient-to-r from-blue-900 to-indigo-800 py-4 px-6 shadow-lg">
    <a href="mainPage.php" class="text-2xl font-bold text-white tracking-wide flex items-center hover-lift">
        <span class="text-yellow-400 mr-1">
        <img src="images/logo/logo.jpg" alt="Logo" class = "rounded-full h-20 w-20">

        </span> 
    </a>
    
    <ul class="flex items-center space-x-6">
        <li><a href="mainPage.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">Home</a></li>
        <li><a href="destination.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">Destinations</a></li>
        <li><a href="feedback.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">Feedback</a></li>
        
        <li class="relative group">
            <button id="dropdownBtn" class="text-white font-medium cursor-pointer focus:outline-none flex items-center hover:text-yellow-300 transition-colors text-2xl">
                Bookings
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="dropdownMenu" class="absolute hidden bg-white text-gray-800 shadow-xl rounded-lg mt-2 w-64 z-50 py-2 border border-gray-100 group-hover:block transform origin-top">
                <li><a href="guidebooking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">👤</span> Hire a Guide</a></li>
                <li><a href="booking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">🏞️</span> Tour Booking</a></li>
                <li><a href="userDashboard.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">📊</span> User Dashboard</a></li>
                <li><a href="packageManagement.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">📦</span> Tour Package Management</a></li>
                <li><a href="customTour.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">✏️</span> Custom Tour Planning</a></li>
            </ul>
        </li>
        <li><a href="about.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">About</a></li>
        
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
                
            });
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
                        <span>Kahan Chale | Jalandhar, Punjab</span>
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
            
     
        
    
        <div >
            <p class="text-gray-400 text-sm">© 2025 Kahan Chale. All rights reserved.</p>
            
        </div>
    </div>
</footer>
</body>
</html>