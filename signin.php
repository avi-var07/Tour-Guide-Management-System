<?php
session_start(); // Start session for authentication

// Database connection
$db = new mysqli('localhost', 'root', '', 'travel');

// Check connection
if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $d = date("Y-m-d H:i:s");

    // Secure query to prevent SQL injection
    $stmt = $db->prepare("SELECT password FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user data
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Insert login entry after successful authentication
            $stmt_log = $db->prepare("INSERT INTO login (user, pass, date_time) VALUES (?, ?, ?)");
            $stmt_log->bind_param("sss", $email, $row['password'], $d);
            $stmt_log->execute();

            $_SESSION['username'] = $email; // Set session
            header("Location: mainPage.html");
            exit();
        }
    }
    header("Location: signin.php?error=invalid"); // Redirect on failure
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<nav class="flex justify-between items-center bg-gray-800 p-4">
        <a href="mainPage.html" class="text-xl font-bold text-blue-400">Tour Operator</a>
        <ul class="flex space-x-4 relative items-center">
            <li><a href="mainPage.html" class="hover:text-yellow-400 text-blue-400">Home</a></li>
            <li><a href="destination.html" class="hover:text-yellow-400 text-blue-400">Destination</a></li>
            <li><a href="feedback.html" class="hover:text-yellow-400 text-blue-400">Feedback</a></li>
            <li class="relative">
              <button id="dropdownBtn" class="text-blue-400 cursor-pointer focus:outline-none flex items-center hover:text-yellow-400">
                Bookings
                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </button>
              <ul id="dropdownMenu" class="absolute hidden bg-gray-800 shadow-lg rounded-md mt-2 w-60 z-50">
                <li><a href="guidebooking.html" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Hire a Guide</a></li>
                <li><a href="booking.html" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Tour Booking</a></li>
                <li><a href="userDashboard.html" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">User Dashboard</a></li>
                <li><a href="packageManagement.html" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Tour Package Management</a></li>
                <li><a href="customTour.html" class="block px-4 py-2 hover:bg-gray-700 text-blue-400">Custom Tour Planning</a></li>
              </ul>
            </li>
            <button id="themeToggle" class="ml-4 bg-gray-700 text-white px-4 py-2 rounded-md text-blue-400">
              <img src="theme_icon.png" height="20px" width="20px">
            </button>
            <li><a href="http://localhost:8080/Project/Github/Tour-Guide-Management-System/signup.php" class="hover:text-red-400 bg-blue-500 text-white px-4 py-2 rounded">Login</a></li>
            
        </ul>
      </nav>

    <div class="bg-white p-6 rounded-lg shadow-lg w-[400px] flexbox justify-center items-center mt-20 mx-auto">
        <fieldset class="border border-gray-300 p-4 rounded-lg">
            <legend class="text-xl font-bold text-gray-700 px-2">Sign In</legend>

            <?php if (isset($_GET['error']) && $_GET['error'] == "invalid") { ?>
                <script>alert('Invalid email or password');</script>
            <?php } ?>

            <form action="signin.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black">
                </div>
                <div class="flex justify-between items-center mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-gray-600">Remember Me</span>
                    </label>
                    <a href="forgot_password.php" class="text-blue-500 text-sm">Forgot Password?</a>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Sign In</button>
            </form>
            
            <p class="mt-4 text-center text-gray-600">
                Don't have an account? <a href="signup.php" class="text-blue-500">Sign Up</a>
            </p>
        </fieldset>
    </div>
    <script>
      document.getElementById("dropdownBtn").addEventListener("click", function () {
          var menu = document.getElementById("dropdownMenu");
          menu.classList.toggle("hidden");
      });
      
      document.addEventListener("click", function (event) {
          var dropdown = document.getElementById("dropdownMenu");
          var button = document.getElementById("dropdownBtn");
          
          if (!dropdown.contains(event.target) && !button.contains(event.target)) {
              dropdown.classList.add("hidden");
          }
      });
  
      document.addEventListener("DOMContentLoaded", function () {
          const themeToggleBtn = document.getElementById("themeToggle");
          const body = document.body;
          
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
      });
    </script>
    <footer class="text-center mt-8 py-4 bg-gray-700 text-white fixed bottom-0 w-full">
    <p>&copy; 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
  </footer>
</body>
</html>
