<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="text-white">
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
    <div class="bg-gray-900 text-white p-6">

    <h1 class="text-2xl font-bold mb-4">Tour Package Management</h1>

    <!-- Add Package Form -->
    <div class="bg-gray-800 p-4 rounded-lg mb-6">
        <h2 class="text-lg font-semibold mb-2">Add New Package</h2>
        <form id="packageForm">
            <input type="text" id="packageName" placeholder="Package Name" class="w-full p-2 rounded mb-2 text-black">
            <input type="text" id="destination" placeholder="Destination" class="w-full p-2 rounded mb-2 text-black">
            <input type="number" id="price" placeholder="Price (₹)" class="w-full p-2 rounded mb-2 text-black">
            <input type="number" id="duration" placeholder="Duration (days)" class="w-full p-2 rounded mb-2 text-black">
            <button type="submit" class="bg-blue-500 px-4 py-2 rounded">Add Package</button>
        </form>
    </div>

    <!-- Package List -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h2 class="text-lg font-semibold mb-2">Available Packages</h2>
        <ul id="packageList" class="list-disc ml-5"></ul>
    </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Fetch & display packages from the database
            function loadPackages() {
                fetch("fetchPackages.php")
                    .then(response => response.json())
                    .then(data => {
                        const packageList = document.getElementById("packageList");
                        packageList.innerHTML = "";
                        data.forEach(pkg => {
                            packageList.innerHTML += `
                                <li class="mb-2">
                                    <strong>${pkg.name}</strong> - ${pkg.destination} | ₹${pkg.price} | ${pkg.duration} days
                                    <button onclick="deletePackage(${pkg.id})" class="text-red-400 ml-2">Delete</button>
                                </li>`;
                        });
                    });
            }

            // Add new package
            document.getElementById("packageForm").addEventListener("submit", function (event) {
                event.preventDefault();
                const packageName = document.getElementById("packageName").value;
                const destination = document.getElementById("destination").value;
                const price = document.getElementById("price").value;
                const duration = document.getElementById("duration").value;

                fetch("addPackage.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ packageName, destination, price, duration }),
                })
                .then(response => response.json())
                .then(() => {
                    loadPackages(); // Refresh list
                    document.getElementById("packageForm").reset();
                });
            });

            // Delete package
            function deletePackage(id) {
                fetch(`deletePackage.php?id=${id}`, { method: "DELETE" })
                    .then(() => loadPackages());
            }

            loadPackages(); // Initial fetch
        });
    </script>
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
<!-- 
 -->