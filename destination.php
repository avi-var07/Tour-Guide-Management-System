<?php
session_start();
$destinations = include 'destinations_data.php';

// Filter logic
$filtered_destinations = $destinations;
$selected_state = isset($_GET['state']) ? $_GET['state'] : 'All';
$selected_budget = isset($_GET['budget']) ? $_GET['budget'] : 'All';
$selected_type = isset($_GET['type']) ? $_GET['type'] : 'All';
$selected_duration = isset($_GET['duration']) ? $_GET['duration'] : 'All';

if ($selected_state !== 'All' || $selected_budget !== 'All' || $selected_type !== 'All' || $selected_duration !== 'All') {
    $filtered_destinations = array_filter($destinations, function ($dest) use ($selected_state, $selected_budget, $selected_type, $selected_duration) {
        $state_match = $selected_state === 'All' || $dest['state'] === $selected_state;
        $budget_match = $selected_budget === 'All' || $dest['budget'] === $selected_budget;
        $type_match = $selected_type === 'All' || $dest['type'] === $selected_type;
        $duration_match = $selected_duration === 'All' || $dest['duration'] === $selected_duration;
        return $state_match && $budget_match && $type_match && $duration_match;
    });
}

// Get unique values for filters
$states = array_unique(array_column($destinations, 'state'));
$budgets = ['Budget', 'Mid-range', 'Luxury'];
$types = ['Adventure', 'Spiritual', 'Chill', 'Party', 'Offbeat'];
$durations = ['Weekend', '5-day', 'Week-long'];
sort($states);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Destinations</title>
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

    <div class="container mx-auto px-4 py-4">
        <form method="GET" action="destination.php" class="flex flex-wrap justify-center mb-8 gap-4">
            <div>
                <label for="state" class="mr-2 text-lg font-semibold text-blue-400">State:</label>
                <select name="state" id="state" onchange="this.form.submit()" class="bg-gray-700 text-white px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="All" <?php echo $selected_state === 'All' ? 'selected' : ''; ?>>All States</option>
                    <?php foreach ($states as $state): ?>
                        <option value="<?php echo htmlspecialchars($state); ?>" <?php echo $selected_state === $state ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($state); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="budget" class="mr-2 text-lg font-semibold text-blue-400">Budget:</label>
                <select name="budget" id="budget" onchange="this.form.submit()" class="bg-gray-700 text-white px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="All" <?php echo $selected_budget === 'All' ? 'selected' : ''; ?>>All Budgets</option>
                    <?php foreach ($budgets as $budget): ?>
                        <option value="<?php echo htmlspecialchars($budget); ?>" <?php echo $selected_budget === $budget ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($budget); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="type" class="mr-2 text-lg font-semibold text-blue-400">Type:</label>
                <select name="type" id="type" onchange="this.form.submit()" class="bg-gray-700 text-white px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="All" <?php echo $selected_type === 'All' ? 'selected' : ''; ?>>All Types</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type); ?>" <?php echo $selected_type === $type ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="duration" class="mr-2 text-lg font-semibold text-blue-400">Duration:</label>
                <select name="duration" id="duration" onchange="this.form.submit()" class="bg-gray-700 text-white px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="All" <?php echo $selected_duration === 'All' ? 'selected' : ''; ?>>All Durations</option>
                    <?php foreach ($durations as $duration): ?>
                        <option value="<?php echo htmlspecialchars($duration); ?>" <?php echo $selected_duration === $duration ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($duration); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>

    <h1 class="text-4xl text-center font-bold mt-8">Popular Destinations</h1>
    <div class="container mx-auto px-4 py-8">
        <?php if (empty($filtered_destinations)): ?>
            <p class="text-center text-gray-400">No destinations match your filters. Try adjusting your selection.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($filtered_destinations as $index => $dest): ?>
                    <div class="p-4 rounded-lg text-center hover:scale-105 transition bg-gray-800 shadow-lg">
                        <img src="<?php echo htmlspecialchars(file_exists($dest['image']) ? $dest['image'] : 'images/destination/default.jpg'); ?>" alt="<?php echo htmlspecialchars($dest['name']); ?>" class="w-full h-60 object-cover rounded-md">
                        <h2 class="text-lg mt-2 font-semibold"><?php echo htmlspecialchars($dest['name']); ?></h2>
                        <p class="text-sm text-gray-400"><?php echo htmlspecialchars($dest['state']); ?> | <?php echo htmlspecialchars($dest['budget']); ?> | <?php echo htmlspecialchars($dest['type']); ?></p>
                        <form method="GET" action="package_details.php">
                            <input type="hidden" name="dest_id" value="<?php echo $index; ?>">
                            <input type="submit" value="View Details" class="bg-blue-500 px-4 py-2 rounded-md mt-2 inline-block hover:bg-blue-600 cursor-pointer text-white">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
                    <li><a href="https://www.instagram.com/" target="_blank" class="hover:text-pink-400 text-gray-300"><i class="fab fa-instagram mr-2"></i>Instagram</a></li>
                    <li><a href="https://x.com/" target="_blank" class="hover:text-blue-400 text-gray-300"><i class="fab fa-twitter mr-2"></i>X</a></li>
                    <li><a href="mailto:support@touroperator.com" class="hover:text-yellow-400 text-gray-300"><i class="fas fa-envelope mr-2"></i>Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 text-center border-t border-gray-600 pt-4">
            <p class="text-gray-400 text-sm">© 2025 Tour Operator. All rights reserved.</p>
        </div>
    </div>
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