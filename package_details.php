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

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8"><?php echo htmlspecialchars($destination['name']); ?> Package Details</h1>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <img src="<?php echo htmlspecialchars(file_exists($destination['image']) ? $destination['image'] : 'images/destination/default.jpg'); ?>" alt="<?php echo htmlspecialchars($destination['name']); ?>" class="w-full h-96 object-cover rounded-md mb-6">
            
            <h2 class="text-2xl font-semibold mb-4">About <?php echo htmlspecialchars($destination['name']); ?></h2>
            <p class="text-gray-300 mb-4">
                Located in <?php echo htmlspecialchars($destination['state']); ?>, this <?php echo htmlspecialchars($destination['type']); ?> destination is perfect for a <?php echo htmlspecialchars($destination['budget']); ?> trip lasting <?php echo htmlspecialchars($destination['duration']); ?>.
            </p>

            <h3 class="text-xl font-semibold mt-6 mb-2">Key Attractions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <?php foreach (array_combine($destination['attractions'], $destination['attractions_images']) as $attraction => $image): ?>
                    <div class="text-center">
                        <img src="<?php echo htmlspecialchars(file_exists($image) ? $image : 'images/destination/default.jpg'); ?>" alt="<?php echo htmlspecialchars($attraction); ?>" class="w-full h-48 object-cover rounded-md mb-2" loading="lazy">
                        <p class="text-gray-300"><?php echo htmlspecialchars($attraction); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

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

            <a href="booking.php?dest=<?php echo urlencode($destination['name']); ?>" class="mt-6 inline-block bg-blue-500 px-6 py-3 rounded-md text-white hover:bg-blue-600">Book Now</a>
        </div>
    </div>

    <footer class="text-center mt-8 py-4 bg-gray-700 text-white">
        <p>© 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
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