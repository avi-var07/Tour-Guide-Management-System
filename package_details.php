<?php
session_start();
$destinations = include 'destinations_data.php';

$dest_id = isset($_GET['dest_id']) ? (int)$_GET['dest_id'] : -1;
$destination = isset($destinations[$dest_id]) ? $destinations[$dest_id] : null;

if (!$destination) {
    header("Location: destination.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title><?php echo htmlspecialchars($destination['name']); ?> Package Details</title>
    <style>
        /* Custom styles for lightbox and carousel */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
        }
        .carousel {
            overflow: hidden;
            position: relative;
        }
        .carousel-inner {
            display: flex;
            transition: transform 0.5s ease;
        }
        .carousel-item {
            min-width: 100%;
            transition: opacity 0.5s ease;
        }
        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }
        .carousel-control.prev {
            left: 0;
        }
        .carousel-control.next {
            right: 0;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white transition-colors duration-300">
    <!-- Navigation -->
    <nav class="flex justify-between items-center bg-gradient-to-r from-blue-900 to-indigo-800 py-4 px-6 shadow-lg">
    <a href="mainPage.php" class="text-2xl font-bold text-white tracking-wide flex items-center hover-lift">
        <span class="text-yellow-400 mr-1">✈️</span> Tour Operator
    </a>
    
    <ul class="flex items-center space-x-6">
        <li><a href="mainPage.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">Home</a></li>
        <li><a href="destination.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">Destinations</a></li>
        <li><a href="feedback.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">Feedback</a></li>
        
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
        <li><a href="about.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">About</a></li>
        
        
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
            <a href="signup.php" class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-5 py-2 rounded-full transition-colors shadow-md hover:shadow-lg hover-lift">
                Login / Sign Up
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold mb-4"><?php echo htmlspecialchars($destination['name']); ?></h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">Located in <?php echo htmlspecialchars($destination['state']); ?> | <?php echo htmlspecialchars($destination['type']); ?> | <?php echo htmlspecialchars($destination['duration']); ?> | <?php echo htmlspecialchars($destination['budget']); ?> Budget</p>
        </div>

        <!-- Image Carousel -->
        <div class="carousel mb-12">
            <div class="carousel-inner">
                <?php foreach ($destination['attractions_images'] as $image): ?>
                    <div class="carousel-item">
                        <img src="<?php echo htmlspecialchars(file_exists($image) ? $image : 'images/destination/default.jpg'); ?>" alt="Attraction" class="w-full h-[500px] object-cover rounded-lg shadow-lg" loading="lazy" onclick="openLightbox(this.src)">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="carousel-control prev" onclick="moveSlide(-1)">&#10094;</div>
            <div class="carousel-control next" onclick="moveSlide(1)">&#10095;</div>
        </div>

        <!-- Lightbox -->
        <div class="lightbox" id="lightbox" onclick="closeLightbox()">
            <img id="lightbox-img" src="" alt="Lightbox Image">
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About Section -->
                <section class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold mb-4">About <?php echo htmlspecialchars($destination['name']); ?></h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4"><?php echo htmlspecialchars($destination['description']); ?></p>
                    <details class="mt-4">
                        <summary class="cursor-pointer text-blue-500 hover:text-blue-600">State Context</summary>
                        <p class="text-gray-700 dark:text-gray-300 mt-2"><?php echo htmlspecialchars($destination['state_context']); ?></p>
                    </details>
                </section>

                <!-- Key Attractions -->
                <section class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold mb-4">Key Attractions</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php foreach ($destination['attractions'] as $index => $attraction): ?>
                            <div class="text-center p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow hover:shadow-lg transition">
                                <img src="<?php echo htmlspecialchars(file_exists($destination['attractions_images'][$index]) ? $destination['attractions_images'][$index] : 'images/destination/default.jpg'); ?>" alt="<?php echo htmlspecialchars($attraction); ?>" class="w-full h-48 object-cover rounded-md mb-4" loading="lazy" onclick="openLightbox(this.src)">
                                <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($attraction); ?></h3>
                                <p class="text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($destination['attractions_descriptions'][$index]); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- Cultural Festivals -->
                <section class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold mb-4">Cultural Festivals</h2>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
                        <?php foreach ($destination['festivals'] as $festival): ?>
                            <li><?php echo htmlspecialchars($festival); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <!-- Local Cuisines -->
                <section class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold mb-4">Local Cuisines</h2>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
                        <?php foreach ($destination['cuisines'] as $cuisine): ?>
                            <li><?php echo htmlspecialchars($cuisine); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <!-- Famous Spots -->
                <section class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold mb-4">Famous Spots</h2>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
                        <?php foreach ($destination['famous_spots'] as $spot): ?>
                            <li><?php echo htmlspecialchars($spot); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <!-- Nearby Destinations -->
                <section class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-3xl font-bold mb-4">Nearby Destinations</h2>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 space-y-2">
                        <?php foreach ($destination['nearby'] as $nearby): ?>
                            <li><?php echo htmlspecialchars($nearby); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            </div>

            <!-- Right Column: Booking -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Book Your Trip</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Experience the wonders of <?php echo htmlspecialchars($destination['name']); ?> with our exclusive package.</p>
                    <a href="guidebooking.php"class="block text-center bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">Book Now</a>
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
          
        
        <!-- Bottom Section with Copyright -->
        <div >
            <p class="text-gray-400 text-sm">© 2025 Tour Operator. All rights reserved.</p>
            
        </div>
    </div>
</footer>
    <!-- JavaScript -->
    <script>
        // Dropdown Handling
        document.addEventListener("DOMContentLoaded", () => {
            const dropdownBtn = document.getElementById("dropdownBtn");
            const dropdownMenu = document.getElementById("dropdownMenu");
            const userDropdownBtn = document.getElementById("userDropdownBtn");
            const userDropdownMenu = document.getElementById("userDropdownMenu");
            const themeToggleBtn = document.getElementById("themeToggle");
            const body = document.body;

            // Bookings Dropdown
            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle("hidden");
                });
                document.addEventListener("click", (e) => {
                    if (!dropdownMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
                        dropdownMenu.classList.add("hidden");
                    }
                });
            }

            // User Dropdown
            if (userDropdownBtn && userDropdownMenu) {
                userDropdownBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    userDropdownMenu.classList.toggle("hidden");
                });
                document.addEventListener("click", (e) => {
                    if (!userDropdownMenu.contains(e.target) && !userDropdownBtn.contains(e.target)) {
                        userDropdownMenu.classList.add("hidden");
                    }
                });
            }


            // Carousel
            let currentSlide = 0;
            const slides = document.querySelectorAll(".carousel-item");
            const totalSlides = slides.length;

            window.moveSlide = (direction) => {
                currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
                document.querySelector(".carousel-inner").style.transform = `translateX(-${currentSlide * 100}%)`;
            };

            // Lightbox
            window.openLightbox = (src) => {
                const lightbox = document.getElementById("lightbox");
                const lightboxImg = document.getElementById("lightbox-img");
                lightboxImg.src = src;
                lightbox.style.display = "flex";
            };

            window.closeLightbox = () => {
                document.getElementById("lightbox").style.display = "none";
            };
        });
    </script>
</body>
</html>
