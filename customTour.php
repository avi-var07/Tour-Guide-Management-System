<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Tour Planning</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <h1 class="text-2xl font-bold mb-4">Plan Your Custom Tour</h1>

    <!-- Custom Tour Form -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <form id="customTourForm">
            <label class="block mb-2">Select Destination:</label>
            <select id="destination" class="w-full p-2 rounded mb-2 text-black">
                <option value="Manali">Manali</option>
                <option value="Goa">Goa</option>
                <option value="Shimla">Shimla</option>
                <option value="Jaipur">Jaipur</option>
            </select>

            <label class="block mb-2">Duration (Days):</label>
            <input type="number" id="duration" class="w-full p-2 rounded mb-2 text-black">

            <label class="block mb-2">Budget (₹):</label>
            <input type="number" id="budget" class="w-full p-2 rounded mb-2 text-black">

            <label class="block mb-2">Additional Services:</label>
            <div class="flex gap-4 mb-2">
                <label><input type="checkbox" id="guide" class="mr-1"> Guide</label>
                <label><input type="checkbox" id="hotel" class="mr-1"> Hotel</label>
                <label><input type="checkbox" id="transport" class="mr-1"> Transport</label>
            </div>

            <button type="submit" class="bg-blue-500 px-4 py-2 rounded">Submit Request</button>
        </form>
    </div>

    <!-- Display User's Custom Requests -->
    <div class="bg-gray-800 p-4 rounded-lg mt-6">
        <h2 class="text-lg font-semibold mb-2">Your Custom Tour Requests</h2>
        <ul id="tourRequests" class="list-disc ml-5"></ul>
    </div>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function loadCustomTours() {
                fetch("fetchCustomTours.php")
                    .then(response => response.json())
                    .then(data => {
                        const tourRequests = document.getElementById("tourRequests");
                        tourRequests.innerHTML = "";
                        data.forEach(tour => {
                            tourRequests.innerHTML += `
                                <li class="mb-2">
                                    <strong>${tour.destination}</strong> - ${tour.duration} days | ₹${tour.budget} 
                                    (${tour.services})
                                    <button onclick="deleteCustomTour(${tour.id})" class="text-red-400 ml-2">Cancel</button>
                                </li>`;
                        });
                    });
            }

            document.getElementById("customTourForm").addEventListener("submit", function (event) {
                event.preventDefault();
                const destination = document.getElementById("destination").value;
                const duration = document.getElementById("duration").value;
                const budget = document.getElementById("budget").value;
                const services = [
                    document.getElementById("guide").checked ? "Guide" : "",
                    document.getElementById("hotel").checked ? "Hotel" : "",
                    document.getElementById("transport").checked ? "Transport" : ""
                ].filter(Boolean).join(", ");

                fetch("addCustomTour.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ destination, duration, budget, services }),
                })
                .then(response => response.json())
                .then(() => {
                    loadCustomTours(); // Refresh list
                    document.getElementById("customTourForm").reset();
                });
            });

            function deleteCustomTour(id) {
                fetch(`deleteCustomTour.php?id=${id}`, { method: "DELETE" })
                    .then(() => loadCustomTours());
            }

            loadCustomTours(); // Initial fetch
        });
    </script>
    <footer class="text-center mt-8 py-4 bg-gray-700 text-white">
        <p>&copy; 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
      </footer>

</body>
</html>
