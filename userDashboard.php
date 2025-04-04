<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
 

    <!-- Dashboard Container -->
    <div class="max-w-4xl mx-auto mt-10 bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6">User Dashboard</h2>

        <!-- Profile Image Section -->
        <div class="flex items-center space-x-4">
            <div id="profileImage" class="w-24 h-24 flex items-center justify-center rounded-full bg-gray-700 text-white text-3xl font-bold"></div>
            <input type="file" id="imageUpload" accept="image/*" class="hidden">
            <button onclick="document.getElementById('imageUpload').click()" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">Upload Image</button>
        </div>

        <!-- Default Avatars -->
        <h3 class="mt-6 text-lg font-semibold">Choose a Default Avatar</h3>
        <div class="flex space-x-4 mt-2">
            <img src="avatars/avatar1.png" class="w-16 h-16 rounded-full cursor-pointer border-2 border-transparent hover:border-yellow-500" onclick="setProfileImage(this.src)">
            <img src="avatars/avatar2.png" class="w-16 h-16 rounded-full cursor-pointer border-2 border-transparent hover:border-yellow-500" onclick="setProfileImage(this.src)">
        </div>

        <!-- Profile Form -->
        <form id="profileForm" class="space-y-4 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-400">Full Name</label>
                <input type="text" id="fullName" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400">Email</label>
                <input type="email" id="email" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400">Phone Number</label>
                <input type="text" id="phone" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400">Change Password</label>
                <input type="password" id="password" class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
            </div>

            <button type="submit" class="w-full bg-yellow-500 text-black px-4 py-2 rounded-lg hover:bg-yellow-600">Update Profile</button>
        </form>

        <!-- Manage Bookings Section -->
        <div class="mt-6">
            <h3 class="text-xl font-bold mb-4">New Booking</h3>
            <a href="booking.php" class="block bg-blue-500 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-600">View My Bookings</a>
        </div>
        <h2 class="text-2xl font-semibold mt-6">Booking & Feedback History</h2>
    <div class="mt-4 bg-gray-700 p-4 rounded-lg">
        <h3 class="text-lg font-semibold">Past Bookings</h3>
        <ul id="userBookings" class="list-disc ml-5 text-gray-300">
            <li class="text-gray-400">Log in to get history</li>
        </ul>

        <h3 class="text-lg font-semibold mt-4">Guide Hire History</h3>
        <ul id="guideHistory" class="list-disc ml-5 text-gray-300">
            <li class="text-gray-400">Log in to get history</li>
        </ul>

        <h3 class="text-lg font-semibold mt-4">Feedback Given</h3>
        <ul id="userFeedback" class="list-disc ml-5 text-gray-300">
            <li class="text-gray-400">Log in to get history</li>
        </ul>
    </div>
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

        $(document).ready(function() {
            $.ajax({
                url: "fetch_customer.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $("#fullname").val(response.fname);
                        $("#email").val(response.email);
                        $("#phone").val(response.phone);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error:", error);
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const userId = localStorage.getItem("user_id"); // Assume user ID is stored in localStorage after login
    
            if (!userId) {
                console.log("User not logged in.");
                return;
            }
    
            // Fetch user history if logged in
            fetch(`fetchUserHistory.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.bookings.length > 0) {
                        document.getElementById("userBookings").innerHTML = 
                            data.bookings.map(booking => `<li>${booking.destination} - ${booking.date}</li>`).join("");
                    }
    
                    if (data.guides.length > 0) {
                        document.getElementById("guideHistory").innerHTML = 
                            data.guides.map(guide => `<li>${guide.name} (${guide.location}) - Rated ${"⭐".repeat(Math.round(guide.rating))}</li>`).join("");
                    }
    
                    if (data.feedback.length > 0) {
                        document.getElementById("userFeedback").innerHTML = 
                            data.feedback.map(feed => `<li>${feed.trip} - "${feed.comment}"</li>`).join("");
                    }
                })
                .catch(error => console.error("Error fetching user history:", error));
        });
        document.addEventListener("DOMContentLoaded", function () {
    fetch('fetch_customer.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
            } else {
                document.getElementById('fullName').value = data.fname;
                document.getElementById('email').value = data.email;
                document.getElementById('phone').value = data.phone;
            }
        })
        .catch(error => console.error('Error fetching user data:', error));
});

        // Fetch User History
        document.getElementById("fetchHistory").addEventListener("click", function () {
            fetch('fetchUserHistory.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById("history").innerHTML = data;
                })
                .catch(error => console.error('Error fetching history:', error));
        });

   
</script>

<!-- User Dashboard Fields -->
<p>Full Name: <span id="fullname"></span></p>
<p>Email: <span id="email"></span></p>
<p>Phone: <span id="phone"></span></p>

    </script>
    <div class="bg-gray-800 p-6 rounded-md shadow-md text-white">
        <h2 class="text-xl font-semibold mb-4">Wallet & Payment Methods</h2>
    
        <!-- Current Balance -->
        <div class="flex justify-between items-center bg-gray-700 p-3 rounded-md mb-4">
            <span class="text-lg">Wallet Balance:</span>
            <span id="walletBalance" class="text-xl font-bold text-yellow-400">₹0</span>
        </div>
    
        <!-- Add Payment Method -->
        <div>
            <h3 class="text-lg font-medium mb-2">Saved Payment Methods</h3>
            <ul id="paymentMethods" class="space-y-3">
                <!-- Dynamically added payment methods will appear here -->
            </ul>
    
            <button onclick="togglePaymentForm()" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-4 py-2 rounded-md mt-3">
                + Add Payment Method
            </button>
        </div>
    
        <!-- Hidden Form for Adding Payment Methods -->
        <div id="paymentForm" class="hidden mt-4 bg-gray-700 p-4 rounded-md">
            <label class="block mb-2">Select Payment Type:</label>
            <select id="paymentType" class="w-full p-2 rounded-md text-black">
                <option value="card">Credit/Debit Card</option>
                <option value="upi">UPI</option>
                <option value="netbanking">Net Banking</option>
            </select>
    
            <input id="paymentDetails" type="text" class="w-full p-2 mt-3 rounded-md text-black" placeholder="Enter details (Card No, UPI ID, etc.)">
            
            <button onclick="addPaymentMethod()" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 mt-3 rounded-md">
                Save
            </button>
        </div>
    </div>
    
    <script>
        function togglePaymentForm() {
            document.getElementById('paymentForm').classList.toggle('hidden');
        }
    
        function addPaymentMethod() {
            const type = document.getElementById('paymentType').value;
            const details = document.getElementById('paymentDetails').value.trim();
    
            if (details === "") {
                alert("Please enter payment details!");
                return;
            }
    
            const paymentList = document.getElementById('paymentMethods');
            const newPayment = document.createElement('li');
            newPayment.classList = "bg-gray-600 p-3 rounded-md flex justify-between items-center";
    
            let typeText = "";
            if (type === "card") typeText = "💳 Card";
            else if (type === "upi") typeText = "📲 UPI";
            else if (type === "netbanking") typeText = "🏦 Net Banking";
    
            newPayment.innerHTML = `
                <span>${typeText}: ${details}</span>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-600">Remove</button>
            `;
    
            paymentList.appendChild(newPayment);
            document.getElementById('paymentDetails').value = "";
            togglePaymentForm();
        }
    </script>
    
    </div>

    <!-- JavaScript for Profile Image & Avatar Selection -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let fullNameInput = document.getElementById("fullName");
            let profileImage = document.getElementById("profileImage");

            // Function to update default profile image
            function updateProfileImage() {
                let username = fullNameInput.value.trim();
                if (username.length > 0) {
                    profileImage.innerHTML = username.charAt(0).toUpperCase();
                    profileImage.style.backgroundImage = "none"; // Remove any uploaded image
                } else {
                    profileImage.innerHTML = "?";
                }
            }

            // Set default profile image based on username
            fullNameInput.addEventListener("input", updateProfileImage);
            updateProfileImage(); // Run on page load

            // Handle Image Upload
            document.getElementById("imageUpload").addEventListener("change", function(event) {
                let file = event.target.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        profileImage.style.backgroundImage = `url(${e.target.result})`;
                        profileImage.style.backgroundSize = "cover";
                        profileImage.style.backgroundPosition = "center";
                        profileImage.innerHTML = ""; // Remove text
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle Avatar Selection
            window.setProfileImage = function(src) {
                profileImage.style.backgroundImage = `url(${src})`;
                profileImage.style.backgroundSize = "cover";
                profileImage.style.backgroundPosition = "center";
                profileImage.innerHTML = ""; // Remove text
            };

            // Handle Form Submission
            document.getElementById("profileForm").addEventListener("submit", function(event) {
                event.preventDefault();
                alert("Profile updated successfully! (Backend integration required)");
            });
        });
    </script>

</body>
</html>
