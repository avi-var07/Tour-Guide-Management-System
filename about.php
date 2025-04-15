<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>About Us - Travel Explorer</title>
</head>
<body class="text-white bg-gray-900">
    <!-- Navigation Bar -->
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
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
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

    <!-- Team Section -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8">About Our Team</h1>
        <p class="text-center font-bold  mb-12 max-w-2xl mx-auto">
            Meet the passionate full-stack developers behind Travel Explorer, dedicated to crafting unforgettable travel experiences through innovative web solutions.
            </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Developer 1 -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <img src="<?php echo file_exists('images/team/developer1.jpg') ? 'images/team/developer1.jpg' : 'images/team/default_team.jpg'; ?>" alt="Ashutosh Mohanty" class="w-full h-64 object-cover object-top">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-blue-400">Ashutosh Mohanty</h2>
                    <p class="text-gray-400 mb-2">Full-Stack Developer</p>
                    <p class="text-gray-300 text-sm mb-4">
                        Ashutosh builds seamless front-end interfaces and robust back-end systems. His passion for travel drives innovative features.
                    </p>
                    <div class="flex gap-4 justify-center mb-4">
                        <a href="https://www.instagram.com/ashu_4789x" target="_blank" title="Instagram" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-instagram"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">Instagram</span>
                        </a>
                        <a href="https://x.com/AshutoshMo72374" target="_blank" title="X" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">X</span>
                        </a>
                        <a href="https://www.linkedin.com/in/ashutosh-mohanty-973369282" target="_blank" title="LinkedIn" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-linkedin-in"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">LinkedIn</span>
                        </a>
                        <a href="https://github.com/Ashu4789" target="_blank" title="GitHub" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-github"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">GitHub</span>
                        </a>
                    </div>
                    <a href="mailto:ashutoshmohanty2004@gmail.com" class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-envelope mr-2"></i>Contact Ashutosh
                    </a>
                </div>
            </div>

            <!-- Developer 2 -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <img src="<?php echo file_exists('images/team/developer2.jpg') ? 'images/team/developer2.jpg' : 'images/team/default_team.jpg'; ?>" alt="Aviral Varshney" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-blue-400">Aviral Varshney</h2>
                    <p class="text-gray-400 mb-2">Full-Stack Developer</p>
                    <p class="text-gray-300 text-sm mb-4">
                        Aviral excels in crafting dynamic front-end designs and secure back-end APIs. His attention to detail ensures smooth travel planning.
                    </p>
                    <div class="flex gap-4 justify-center mb-4">
                        <a href="https://www.instagram.com/aviral.varshney.717" target="_blank" title="Instagram" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-instagram"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">Instagram</span>
                        </a>
                        <a href="https://x.com/aviral_717" target="_blank" title="X" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">X</span>
                        </a>
                        <a href="https://www.linkedin.com/in/avi7/" target="_blank" title="LinkedIn" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-linkedin-in"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">LinkedIn</span>
                        </a>
                        <a href="https://github.com/avi-var07" target="_blank" title="GitHub" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-github"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">GitHub</span>
                        </a>
                    </div>
                    <a href="mailto:aviralvarshney07@gmail.com" class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-envelope mr-2"></i>Contact Aviral
                    </a>
                </div>
            </div>

            <!-- Developer 3 -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <img src="<?php echo file_exists('images/team/developer3.jpg') ? 'images/team/developer3.jpg' : 'images/team/default_team.jpg'; ?>" alt="Ram Arora" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-blue-400">Ram Arora</h2>
                    <p class="text-gray-400 mb-2">Full-Stack Developer</p>
                    <p class="text-gray-300 text-sm mb-4">
                        Ram bridges front-end aesthetics with back-end functionality, creating intuitive travel platforms. His creativity enhances user engagement.
                    </p>
                    <div class="flex gap-4 justify-center mb-4">
                        <a href="https://www.instagram.com/ram.01_" target="_blank" title="Instagram" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-instagram"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">Instagram</span>
                        </a>
                        <a href="https://x.com/ram_arora" target="_blank" title="X" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">X</span>
                        </a>
                        <a href="https://www.linkedin.com/in/ram-ar-32a6472a4/" target="_blank" title="LinkedIn" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-linkedin-in"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">LinkedIn</span>
                        </a>
                        <a href="https://github.com/ramarora00" target="_blank" title="GitHub" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-github"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">GitHub</span>
                        </a>
                    </div>
                    <a href="mailto:ramarora0075@gmail.com" class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-envelope mr-2"></i>Contact Ram
                    </a>
                </div>
            </div>

            <!-- Developer 4 -->
            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <img src="<?php echo file_exists('images/team/developer4.jpg') ? 'images/team/developer4.jpg' : 'images/team/default_team.jpg'; ?>" alt="Siddharth Sharma" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-blue-400">Siddharth Sharma</h2>
                    <p class="text-gray-400 mb-2">Full-Stack Developer</p>
                    <p class="text-gray-300 text-sm mb-4">
                        Siddharth delivers end-to-end solutions, from vibrant UI to scalable back-end systems. His love for travel fuels innovative features.
                    </p>
                    <div class="flex gap-4 justify-center mb-4">
                        <a href="https://instagram.com/S_iddharth73" target="_blank" title="Instagram" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-instagram"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">Instagram</span>
                        </a>
                        <a href="https://x.com/n3ro_73" target="_blank" title="X" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">X</span>
                        </a>
                        <a href="https://linkedin.com/in/siddharth-sharma-ba693a294" target="_blank" title="LinkedIn" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-linkedin-in"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">LinkedIn</span>
                        </a>
                        <a href="https://github.com/Siddharth-73" target="_blank" title="GitHub" class="text-blue-400 hover:text-yellow-400 text-2xl hover:scale-110 transition-transform relative group">
                            <i class="fab fa-github"></i>
                            <span class="absolute hidden group-hover:block bg-gray-700 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2">GitHub</span>
                        </a>
                    </div>
                    <a href="mailto:sharmasiddharth7373@gmail.com" class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-envelope mr-2"></i>Contact Siddharth
                    </a>
                </div>
            </div>
        </div>
    </div>
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
                    <li><a href="guidebooking.php" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-user-guide mr-2"></i>Hire a Guide</a></li>
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

    <!-- JavaScript for Dropdowns and Theme Toggle -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Bookings Dropdown
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

            // Theme Toggle
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

            // User Dropdown
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
</body>
</html>