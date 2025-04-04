<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Booking Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="">
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
    <!-- Booking Form -->
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Book A Memory with Us</h1>
            <form method="POST" action="booking.php" name="form" onsubmit="return validateForm()" class="space-y-4">

                <input type="text" name="ffirst" placeholder="First Name" class="w-full p-3 border rounded-lg focus:ring focus:ring-orange-300 text-black" required>
                <input type="text" name="flast" placeholder="Last Name" class="w-full p-3 border rounded-lg focus:ring focus:ring-orange-300 text-black" required>
                <input type="email" name="femail" placeholder="Email" class="w-full p-3 border rounded-lg focus:ring focus:ring-orange-300 text-black" required>

            
                <input type="text" id="pincode" name="pincode" required maxlength="6" pattern="[0-9]{6}"
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black"
                placeholder="Pincode" onkeyup="fetchLocation()">

            
                <input type="text" id="city" name="city" placeholder="City" class="w-full p-3 border rounded-lg focus:ring focus:ring-orange-300 text-black" readonly required>
                <input type="text" id="state" name="state" placeholder="State" class="w-full p-3 border rounded-lg focus:ring focus:ring-orange-300 text-black" readonly required>

                <input type="tel" name="fphone" pattern="[0-9]{10}" maxlength="10" placeholder="Phone" class="w-full p-3 border rounded-lg focus:ring focus:ring-orange-300 text-black" pattern="[0-9]{10}" required>
                <input type="text" name="fdesti" placeholder="Destination" class="w-full p-3 border rounded-lg focus:ring focus:ring-orange-300 text-black" required>

                <button type="submit" class="w-full bg-orange-500 text-white p-3 rounded-lg hover:bg-orange-600 transition duration-300">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            let firstName = document.forms["form"]["ffirst"].value.trim();
            let lastName = document.forms["form"]["flast"].value.trim();
            let email = document.forms["form"]["femail"].value.trim();
            let phone = document.forms["form"]["fphone"].value.trim();
            let pincode = document.getElementById("pincode").value.trim();

            if (firstName === "" || lastName === "") {
                alert("First and Last name are required!");
                return false;
            }
            if (!/^\S+@\S+\.\S+$/.test(email)) {
                alert("Please enter a valid email!");
                return false;
            }
            if (!/^\d{10}$/.test(phone)) {
                alert("Phone number must be 10 digits!");
                return false;
            }
            if (!/^\d{6}$/.test(pincode)) {
                alert("Pincode must be 6 digits!");
                return false;
            }
            return true;
        }

        function fetchLocation() {
            let pincode = document.getElementById("pincode").value;
            let cityField = document.getElementById("city");
            let stateField = document.getElementById("state");

            if (pincode.length === 6) {
                fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data[0] && data[0].Status === "Success" && data[0].PostOffice) {
                            cityField.value = data[0].PostOffice[0].District;
                            stateField.value = data[0].PostOffice[0].State;
                        } else {
                            cityField.value = "";
                            stateField.value = "";
                            alert("Invalid Pincode! Please enter a valid one.");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching location:", error);
                        cityField.value = "";
                        stateField.value = "";
                        alert("Could not fetch location. Please try again.");
                    });
            }
        }
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

<footer class="text-center mt-8 py-4 bg-gray-700 text-white">
    <p>&copy; 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
  </footer>
</body>
</html>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["ffirst"]);
    $last_name = trim($_POST["flast"]);
    $email = trim($_POST["femail"]);
    $pincode = trim($_POST["pincode"]);
    $city = trim($_POST["city"]);
    $state = trim($_POST["state"]);
    $phone = trim($_POST["fphone"]);
    $destination = trim($_POST["fdesti"]);

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($pincode) || empty($city) || empty($state) || empty($phone) || empty($destination)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // Insert Data into Database
    $stmt = $conn->prepare("INSERT INTO bookings (first_name, last_name, email, pincode, city, state, phone, destination) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $pincode, $city, $state, $phone, $destination);

    if ($stmt->execute()) {
        echo "<script>alert('Booking Successful!'); window.location.href='mainpage.php';</script>";
    } else {
        echo "<script>alert('Error occurred! Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>