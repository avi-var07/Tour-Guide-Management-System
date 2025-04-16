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
    <nav class="bg-gray-800 p-4 sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="mainPage.php" class="text-2xl font-bold text-blue-400 hover:text-blue-300 transition">Tour Operator</a>
            <ul class="flex space-x-6 items-center">
                <li><a href="mainPage.php" class="text-blue-400 hover:text-yellow-400 transition">Home</a></li>
                <li><a href="destination.php" class="text-blue-400 hover:text-yellow-400 transition">Destination</a></li>
                <li><a href="feedback.php" class="text-blue-400 hover:text-yellow-400 transition">Feedback</a></li>
                <li class="relative">
                    <button id="dropdownBtn" class="text-blue-400 hover:text-yellow-400 flex items-center focus:outline-none transition">
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
                <li><a href="about.php" class="text-blue-400 hover:text-yellow-400 transition">About</a></li>
                <button id="themeToggle" class="ml-4 bg-gray-700 text-blue-400 px-3 py-2 rounded-md hover:bg-gray-600 transition">
                    <i class="fas fa-moon"></i>
                </button>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="relative">
                        <button id="userDropdownBtn" class="text-blue-400 hover:text-yellow-400 flex items-center focus:outline-none transition">
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
                    <li><a href="signup.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
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
                    <a href="booking.php?destination=<?php echo urlencode($destination['name']); ?>&price=<?php echo isset($destination['price']) ? $destination['price'] : '1299'; ?>" class="block text-center bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition">Book Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-700 text-white text-center py-6 mt-12">
        <p>© 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400 transition">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400 transition">Twitter</a></p>
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

            // Theme Toggle
            if (themeToggleBtn) {
                const savedTheme = localStorage.getItem("theme") || "dark";
                body.classList.toggle("bg-gray-100", savedTheme === "light");
                body.classList.toggle("bg-gray-900", savedTheme === "dark");
                body.classList.toggle("text-gray-900", savedTheme === "light");
                body.classList.toggle("text-white", savedTheme === "dark");
                themeToggleBtn.innerHTML = savedTheme === "light" ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';

                themeToggleBtn.addEventListener("click", () => {
                    const newTheme = body.classList.contains("bg-gray-900") ? "light" : "dark";
                    body.classList.toggle("bg-gray-100", newTheme === "light");
                    body.classList.toggle("bg-gray-900", newTheme === "dark");
                    body.classList.toggle("text-gray-900", newTheme === "light");
                    body.classList.toggle("text-white", newTheme === "dark");
                    themeToggleBtn.innerHTML = newTheme === "light" ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
                    localStorage.setItem("theme", newTheme);
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