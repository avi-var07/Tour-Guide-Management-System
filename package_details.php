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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo htmlspecialchars($destination['name']); ?> Package Details</title>
    <style>
        .slideshow-container {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
        }
        .slide {
            display: none;
            width: 100%;
        }
        .slide img {
            width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: auto;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            background-color: rgba(0,0,0,0.5);
        }
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }
        .prev:hover, .next:hover {
            background-color: rgba(0,0,0,0.8);
        }
        .dots {
            text-align: center;
            padding: 10px 0;
        }
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }
        .active, .dot:hover {
            background-color: #717171;
        }
    </style>
</head>
<body class="text-white bg-gray-900">
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

    <div class="slideshow-container">
        <div class="slide">
            <img src="<?php echo htmlspecialchars(file_exists($destination['image']) ? $destination['image'] : 'images/destination/default.jpg'); ?>" alt="<?php echo htmlspecialchars($destination['name']); ?>">
        </div>
        <?php foreach ($destination['attractions_images'] as $image): ?>
            <div class="slide">
                <img src="<?php echo htmlspecialchars(file_exists($image) ? $image : 'images/destination/default.jpg'); ?>" alt="Attraction">
            </div>
        <?php endforeach; ?>
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
    </div>
    <div class="dots">
        <span class="dot" onclick="currentSlide(1)"></span>
        <?php for ($i = 0; $i < count($destination['attractions_images']); $i++): ?>
            <span class="dot" onclick="currentSlide(<?php echo $i + 2; ?>)"></span>
        <?php endfor; ?>
    </div>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8"><?php echo htmlspecialchars($destination['name']); ?> Package Details</h1>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4">About <?php echo htmlspecialchars($destination['name']); ?></h2>
            <p class="text-gray-300 mb-4">
                Located in <?php echo htmlspecialchars($destination['state']); ?>, this <?php echo htmlspecialchars($destination['type']); ?> destination is perfect for a <?php echo htmlspecialchars($destination['budget']); ?> trip lasting <?php echo htmlspecialchars($destination['duration']); ?>.
            </p>

            <h3 class="text-xl font-semibold mt-6 mb-2">Key Attractions</h3>
            <ul class="list-disc list-inside text-gray-300 mb-6">
                <?php foreach ($destination['attractions'] as $attraction): ?>
                    <li><?php echo htmlspecialchars($attraction); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3 class="text-xl font-semibold mt-6 mb-2">Cultural Festivals</h3>
            <ul class="list-disc list-inside text-gray-300">
                <?php foreach ($destination['festivals'] as $festival): ?>
                    <li><?php echo htmlspecialchars($festival); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3 class="text-xl font-semibold mt-6 mb-2">Local Cuisines</h3>
            <ul class="list-disc list-inside text-gray-300">
                <?php foreach ($destination['cuisines'] as $cuisine): ?>
                    <li><?php echo htmlspecialchars($cuisine); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3 class="text-xl font-semibold mt-6 mb-2">Famous Spots</h3>
            <ul class="list-disc list-inside text-gray-300">
                <?php foreach ($destination['famous_spots'] as $spot): ?>
                    <li><?php echo htmlspecialchars($spot); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3 class="text-xl font-semibold mt-6 mb-2">Nearby Destinations</h3>
            <ul class="list-disc list-inside text-gray-300">
                <?php foreach ($destination['nearby'] as $nearby): ?>
                    <li><?php echo htmlspecialchars($nearby); ?></li>
                <?php endforeach; ?>
            </ul>

            <a href="booking.php?destination=<?php echo urlencode($destination['name']); ?>&price=1299" class="book-now-btn mt-6 inline-block bg-blue-500 px-6 py-3 rounded-md text-black hover:bg-blue-600">Book Now</a>
        </div>
    </div>

    <footer class="text-center mt-8 py-4 bg-gray-700 text-white">
        <p>© 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
    </footer>

    <script>
        let slideIndex = 1;
        let slideInterval;

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("slide");
            let dots = document.getElementsByClassName("dot");

            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }

        function plusSlides(n) {
            clearInterval(slideInterval);
            showSlides(slideIndex += n);
            startSlideShow();
        }

        function currentSlide(n) {
            clearInterval(slideInterval);
            showSlides(slideIndex = n);
            startSlideShow();
        }

        function startSlideShow() {
            slideInterval = setInterval(() => {
                plusSlides(1);
            }, 3000); // Changed to 3000ms (3 seconds)
        }

        document.addEventListener("DOMContentLoaded", function () {
            showSlides(slideIndex);
            startSlideShow();

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