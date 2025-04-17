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
            
           
        
 
        <div >
            <p class="text-gray-400 text-sm">© 2025 Tour Operator. All rights reserved.</p>
            
        </div>
    </div>
</footer>
  
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