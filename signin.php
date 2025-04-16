<?php
session_start(); // Start session for authentication

// Database connection
$db = new mysqli('localhost', 'root', '', 'travel');

// Check connection
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $d = date("Y-m-d H:i:s");

    // Secure query to prevent SQL injection
    $stmt = $db->prepare("SELECT password FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user data
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Insert login entry after successful authentication
            $stmt_log = $db->prepare("INSERT INTO login (user, pass, date_time) VALUES (?, ?, ?)");
            $stmt_log->bind_param("sss", $email, $row['password'], $d);
            $stmt_log->execute();

            $_SESSION['username'] = $email; // Set session
            header("Location: mainpage.php");
            exit();
        }
    }
    header("Location: signin.php?error=invalid"); // Redirect on failure
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
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
            <legend class="text-xl font-bold text-gray-700 px-2">Sign In</legend>

            <?php if (isset($_GET['error']) && $_GET['error'] == "invalid") { ?>
                <script>alert('Invalid email or password');</script>
            <?php } ?>

            <form action="signin.php" method="POST" class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold text-center text-blue-800 mb-6">Welcome Back</h2>
    
    <!-- Email Field -->
    <div class="mb-5">
        <label class="block text-gray-700 font-medium mb-1">Email Address</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </span>
            <input type="email" name="email" required class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800" placeholder="Your email address">
        </div>
    </div>
    
    <!-- Password Field -->
    <div class="mb-5">
        <label class="block text-gray-700 font-medium mb-1">Password</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </span>
            <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-800" placeholder="Your password">
        </div>
    </div>
    
    <!-- Remember Me & Forgot Password -->
    <div class="flex justify-between items-center mb-6">
        <label class="inline-flex items-center text-gray-600 hover:text-gray-800 cursor-pointer">
            <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <span class="ml-2 text-sm">Remember Me</span>
        </label>
        <a href="forgot_password.php" class="text-blue-600 text-sm hover:text-blue-800 hover:underline font-medium">Forgot Password?</a>
    </div>
    
    <!-- Sign In Button -->
    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300 font-medium shadow-md">
        Sign In
    </button>
    
    <!-- Create Account Link -->
    <p class="text-center text-gray-600 mt-6">Don't have an account? 
        <a href="signup.php" class="text-blue-600 font-medium hover:underline">Create one now</a>
    </p>
    
    <!-- Optional: Social Login Divider -->
    <div class="relative flex items-center justify-center mt-6">
        <div class="absolute border-t border-gray-300 w-full"></div>
        <div class="relative bg-white px-4 text-sm text-gray-500">or continue with</div>
    </div>
    
    <!-- Optional: Social Login Buttons -->
    <div class="grid grid-cols-3 gap-3 mt-6">
        <button type="button" class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934 0-.528-.081-1.097-.202-1.625z" fill="#4285F4"/>
            </svg>
        </button>
        <button type="button" class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z" fill="#3b5998"/>
            </svg>
        </button>
        <button type="button" class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.7 8.037c-.021-.608-.11-1.017-.233-1.38a2.782 2.782 0 0 0-.657-1.007 2.79 2.79 0 0 0-1.006-.656c-.363-.123-.772-.212-1.38-.233-.61-.028-1.04-.034-2.424-.034s-1.814.006-2.424.034c-.608.021-1.017.11-1.38.233a2.788 2.788 0 0 0-1.007.656 2.79 2.79 0 0 0-.656 1.006c-.123.364-.212.773-.233 1.38-.028.61-.034 1.04-.034 2.424s.006 1.814.034 2.425c.021.608.11 1.016.233 1.38.123.393.32.715.656 1.006.292.336.614.534 1.007.656.363.123.772.212 1.38.233.61.028 1.04.034 2.424.034s1.814-.006 2.425-.034c.608-.021 1.016-.11 1.38-.233a2.786 2.786 0 0 0 1.663-1.663c.123-.363.212-.772.233-1.38.028-.61.034-1.04.034-2.424s-.006-1.814-.034-2.425zm-1.06 4.797c-.02.558-.12.862-.198 1.064a1.804 1.804 0 0 1-1.05 1.05c-.202.079-.506.177-1.064.198-.604.027-.825.034-2.328.034-1.503 0-1.724-.007-2.328-.034-.558-.02-.862-.12-1.064-.198a1.73 1.73 0 0 1-.652-.425 1.73 1.73 0 0 1-.425-.652c-.079-.202-.177-.506-.198-1.064-.027-.604-.034-.825-.034-2.328 0-1.503.007-1.724.034-2.328.02-.558.12-.862.198-1.064.092-.262.242-.45.425-.652.202-.183.39-.333.652-.425.202-.079.506-.177 1.064-.198.604-.027.825-.034 2.328-.034 1.503 0 1.724.007 2.328.034.558.02.862.12 1.064.198.262.092.45.242.652.425.183.202.333.39.425.652.079.202.177.506.198 1.064.027.604.034.825.034 2.328 0 1.503-.007 1.724-.034 2.328z" fill="#e4405f"/>
            </svg>
        </button>
    </div>
</form>
            
            <p class="mt-4 text-center text-gray-600">
                Don't have an account? <a href="signup.php" class="text-blue-500">Sign Up</a>
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
