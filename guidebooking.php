<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
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
                <li><a href="package LATManagement.php" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Tour Package Management</a></li>
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

    <!-- Page Title -->
    <div class="container mx-auto px-4 py-8 text-center">
        <h1 class="text-3xl font-bold mb-4">Find & Book a Guide</h1>
        <p class="text-gray-400">Choose from our expert guides for your trip.</p>
    </div>

    <!-- Filters -->
    <div class="container mx-auto px-4 mb-6">
        <div class="flex justify-center gap-4">
            <select id="locationFilter" class="bg-gray-700 text-white px-4 py-2 rounded-md">
                <option value="">Select Location</option>
                <option value="Goa">Goa</option>
                <option value="Kerala">Kerala</option>
                <option value="Ladakh">Ladakh</option>
                <option value="Rajasthan">Rajasthan</option>
            </select>

            <select id="expertiseFilter" class="bg-gray-700 text-white px-4 py-2 rounded-md">
                <option value="">Select Expertise</option>
                <option value="Adventure">Adventure</option>
                <option value="Cultural">Cultural</option>
                <option value="Wildlife">Wildlife</option>
                <option value="Historical">Historical</option>
            </select>

            <button onclick="filterGuides()" class="bg-blue-500 px-6 py-2 rounded-md hover:bg-blue-600">Apply Filters</button>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div id="guideList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        </div>
    </div>

    <footer class="text-center py-4 bg-gray-700 text-white fixed bottom-0 w-full">
        <p>© 2025 Tour Operator | 
            <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | 
            <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a>
        </p>
    </footer>
    
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

        const guides = [
            { id: 1, name: "Ravi Sharma", location: "Goa", expertise: "Adventure", experience: "5 Years", rating: 4.7, available: true },
            { id: 2, name: "Priya Mehta", location: "Kerala", expertise: "Cultural", experience: "7 Years", rating: 4.9, available: true },
            { id: 3, name: "Amit Kumar", location: "Ladakh", expertise: "Wildlife", experience: "4 Years", rating: 4.5, available: false },
            { id: 4, name: "Sanya Gupta", location: "Rajasthan", expertise: "Historical", experience: "6 Years", rating: 4.8, available: true },
            { id: 5, name: "Vikram Singh", location: "Goa", expertise: "Wildlife", experience: "3 Years", rating: 4.4, available: true },
            { id: 6, name: "Anjali Nair", location: "Kerala", expertise: "Adventure", experience: "8 Years", rating: 4.6, available: false },
            { id: 7, name: "Karan Thakur", location: "Ladakh", expertise: "Adventure", experience: "6 Years", rating: 4.8, available: true },
            { id: 8, name: "Meera Joshi", location: "Rajasthan", expertise: "Cultural", experience: "5 Years", rating: 4.7, available: true },
            { id: 9, name: "Suresh Patel", location: "Goa", expertise: "Historical", experience: "10 Years", rating: 4.9, available: true },
            { id: 10, name: "Nisha Rawat", location: "Kerala", expertise: "Wildlife", experience: "4 Years", rating: 4.5, available: false },
            { id: 11, name: "Rahul Desai", location: "Goa", expertise: "Cultural", experience: "6 Years", rating: 4.6, available: true },
            { id: 12, name: "Lakshmi Menon", location: "Kerala", expertise: "Historical", experience: "9 Years", rating: 4.8, available: true },
            { id: 13, name: "Tenzin Norbu", location: "Ladakh", expertise: "Cultural", experience: "5 Years", rating: 4.7, available: false },
            { id: 14, name: "Arjun Rathore", location: "Rajasthan", expertise: "Adventure", experience: "7 Years", rating: 4.9, available: true },
            { id: 15, name: "Deepa Kulkarni", location: "Goa", expertise: "Wildlife", experience: "4 Years", rating: 4.5, available: true },
            { id: 16, name: "Manu Varghese", location: "Kerala", expertise: "Adventure", experience: "6 Years", rating: 4.7, available: true },
            { id: 17, name: "Sonam Dorji", location: "Ladakh", expertise: "Historical", experience: "8 Years", rating: 4.8, available: true },
            { id: 18, name: "Kavita Sharma", location: "Rajasthan", expertise: "Wildlife", experience: "5 Years", rating: 4.6, available: false },
            { id: 19, name: "Naveen D’Souza", location: "Goa", expertise: "Adventure", experience: "7 Years", rating: 4.8, available: true },
            { id: 20, name: "Rekha Pillai", location: "Kerala", expertise: "Cultural", experience: "6 Years", rating: 4.7, available: true }
        ];

        function loadGuides(filterLocation = "", filterExpertise = "") {
            const guideList = document.getElementById("guideList");
            guideList.innerHTML = ""; // Clear previous results

            guides.forEach(guide => {
                if ((filterLocation === "" || guide.location === filterLocation) &&
                    (filterExpertise === "" || guide.expertise === filterExpertise)) {

                    guideList.innerHTML += `
                        <div class="p-6 rounded-lg text-center border-2 border-black">
                            <h2 class="text-xl font-semibold">${guide.name}</h2>
                            <p class="text-gray-400">${guide.expertise} Guide | ${guide.location}</p>
                            <p class="text-gray-400">Experience: ${guide.experience}</p>
                            <p class="text-yellow-400">⭐ ${guide.rating}</p>
                            ${guide.available 
                                ? `<button class="bg-green-500 px-4 py-2 rounded-md mt-2 hover:bg-green-600" onclick="bookGuide('${guide.name}')">Book Now</button>`
                                : `<p class="text-red-500 mt-2">Not Available</p>`}
                        </div>
                    `;
                }
            });
        }

        function filterGuides() {
            const selectedLocation = document.getElementById("locationFilter").value;
            const selectedExpertise = document.getElementById("expertiseFilter").value;
            loadGuides(selectedLocation, selectedExpertise);
        }

        function bookGuide(guideName) {
            window.location.href = `booking.php?guide=${encodeURIComponent(guideName)}`;
        }

        // Load all guides on page load
        loadGuides();
    </script>
</body>
</html>