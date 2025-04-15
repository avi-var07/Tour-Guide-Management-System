<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

  <header class="relative">
    <div class="slideshow-container w-full overflow-hidden relative">
      <div class="mySlides w-full hidden">
        <img src="front3.jpg" class="w-full h-[400px] object-cover">
      </div>
      <div class="mySlides w-full hidden">
        <img src="front2.jpg" class="w-full h-[400px] object-cover">
      </div>
      <div class="mySlides w-full hidden">
        <img src="front1.jpg" class="w-full h-[400px] object-cover">
      </div>
      <button onclick="plusSlides(-1)" class="absolute left-2 top-1/2 text-2xl">&#10094;</button>
      <button onclick="plusSlides(1)" class="absolute right-2 top-1/2 text-2xl">&#10095;</button>
    </div>
      
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtn = document.getElementById("dropdownBtn");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const userDropdownBtn = document.getElementById("userDropdownBtn");
    const userDropdownMenu = document.getElementById("userDropdownMenu");
    const themeToggleBtn = document.getElementById("themeToggle");
    const body = document.body;

    // Bookings Dropdown Toggle
    if (dropdownBtn && dropdownMenu) {
        dropdownBtn.addEventListener("click", function (event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function (event) {
            if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });
    }

    // User Dropdown Toggle
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

    // Theme Toggle
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
});
</script>
  </header>

  <section class="text-center my-8">
    <h1 class="text-3xl font-bold">Tourism Management System</h1>
  </section>

  <section class="container mx-auto px-4">
    <h2 class="text-2xl font-semibold text-center mb-4">Popular Destinations</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 z-10">
      <div class="p-4 rounded-lg text-center transition-transform transform hover:scale-105">
        <img src="images/destination/jaipur/hawa_mahal.jpg" class="w-full h-60 object-cover rounded-md">
        <h3 class="text-lg mt-2">Jaipur</h3>
        <a href="destination.php" class="bg-blue-500 px-4 py-2 rounded-md mt-2 inline-block hover:bg-blue-600">Visit</a>
      </div>
      <div class="p-4 rounded-lg text-center transition-transform transform hover:scale-105">
        <img src="images/destination/leh_ladakh.jpg" class="w-full h-60 object-cover rounded-md">
        <h3 class="text-lg mt-2">Ladakh</h3>
        <a href="destination.php" class="bg-blue-500 px-4 py-2 rounded-md mt-2 inline-block hover:bg-blue-600">Visit</a>
      </div>
      <div class="p-4 rounded-lg text-center transition-transform transform hover:scale-105">
        <img src="images/destination/varanasi/kashi_vishwanath_temple.webp" class="w-full h-60 object-cover rounded-md">
        <h3 class="text-lg mt-2">Varanasi</h3>
        <a href="destination.php" class="bg-blue-500 px-4 py-2 rounded-md mt-2 inline-block hover:bg-blue-600">Visit</a>
      </div>
      <div class="p-4 rounded-lg text-center transition-transform transform hover:scale-105">
        <img src="images/destination/auli/auli.jpg" class="w-full h-60 object-cover rounded-md">
        <h3 class="text-lg mt-2">Auli</h3>
        <a href="destination.php" class="bg-blue-500 px-4 py-2 rounded-md mt-2 inline-block hover:bg-blue-600">Visit</a>
      </div>
    </div>
  </section>

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
    let slideIndex = 0;
    showSlides();
    function showSlides() {
      let slides = document.getElementsByClassName("mySlides");
      for (let i = 0; i < slides.length; i++) {
        slides[i].classList.add("hidden");
      }
      slideIndex++;
      if (slideIndex > slides.length) { slideIndex = 1; }
      slides[slideIndex - 1].classList.remove("hidden");
      setTimeout(showSlides, 3000);
    }
    function plusSlides(n) {
      slideIndex += n - 1;
      showSlides();
    }
  </script>
</body>
</html>