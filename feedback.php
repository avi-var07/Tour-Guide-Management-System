<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tour Feedback Form</title>
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

    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-center mb-6">Tour Feedback Form</h1>
        <p class="text-center text-semibold text-blue-400 mb-6">We would love to hear your feedback so we can improve our services. Thank you!</p>

        
        <form name='feedbackForm' method="POST" action="feedback.php" class="max-w-3xl mx-auto bg-green-500 p-6 rounded-lg shadow-lg">
            <!-- Tour Guide Name -->
            <div class="mb-4">
                <label class="text-black font-semibold mb-1">Tour Guide Name</label>
                <div class="flex space-x-4">
                    <input type="text" name="guide_fname" placeholder="Name" required class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
                
                </div>
            </div>

            <!-- Trip Name -->
            <div class="mb-4">
                <label class="text-black font-semibold mb-1">Trip Name</label>
                <input type="text" name="trip_name" placeholder="Trip Name" required class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
            </div>

            <!-- Trip Destination -->
            <div class="mb-4">
                <label class="text-black font-semibold mb-1">Trip Destination</label>
                <input type="text" name="trip_destination" placeholder="Trip Destination" required class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600">
            </div>
            <!-- Departure Date -->
            <div class="mb-4">
                <label class="text-black font-semibold mb-1">Trip Departure Date</label>
                <input type="date" name="departure_date" required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:ring-2 focus:ring-blue-500">
            </div>


        
            <div class="mb-6">
                <label class="text-black font-semibold mb-2">Please rate us using the following criteria:</label>
                <table class="w-full text-center border border-gray-600 text-white">
                    <tr>
                        <th class="border border-gray-600 p-2">Criteria</th>
                        <th class="border border-gray-600 p-2">Excellent</th>
                        <th class="border border-gray-600 p-2">Satisfactory</th>
                        <th class="border border-gray-600 p-2">Needs Improvement</th>
                        <th class="border border-gray-600 p-2">Not Satisfied</th>
                    </tr>
            
                    <script>
                        let criteria = ["Accommodation", "Transport", "Food", "Places", "Professionalism", "Costs", "Ease of Communication", "Safety", "Driver", "Tour Guide", "Knowledge", "Registration Process", "Payment Process"];
                        document.write(criteria.map(c => `
                            <tr>
                                <td class="border border-gray-600 p-2">${c}</td>
                                ${["Excellent", "Satisfactory", "Needs Improvement", "Not Satisfied"].map(val => `
                                    <td><input type="radio" name="${c.toLowerCase().replace(/\s+/g, '_')}" value="${val}"></td>
                                `).join('')}
                            </tr>
                        `).join(''));
                    </script>
                </table>
            </div>

        
            <div class="mb-4">
                <label class="text-black font-semibold mb-1">What is your overall rating of the tour experience?</label>
                <div id="starRating" class="flex space-x-1 text-yellow-500 text-2xl cursor-pointer"></div>
                <input type="hidden" name="overall_rating" id="ratingValue">
            </div>
            
            <div class="mb-4">
                <label class="text-black font-semibold mb-1">What were the places you enjoyed during this tour?</label>
                <textarea name="places_enjoyed" rows="3" placeholder="Type here..." required
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600"></textarea>
            </div>

            <div class="mb-4">
                <label class="text-black font-semibold mb-1">What were the places you did not enjoy during this tour?</label>
                <textarea name="places_not_enjoyed" rows="3" placeholder="Type here..."
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600"></textarea>
            </div>

            <div class="mb-4">
                <label class="text-black font-semibold mb-1">What places would you like to visit next?</label>
                <textarea name="places_next" rows="3" placeholder="Type here..."
                    class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600"></textarea>
            </div>
        
            <div class="mb-4">
                <label for="heard_about_us" class="text-black font-semibold mb-1 block">How did you hear about us?</label>
                <select name="heard_about_us" id="heard_about_us" class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-blue-500">
                    <option value="" disabled selected class="text-gray-400">Please Select</option>
                    <option value="social_media">Social Media</option>
                    <option value="friend_referral">Friend Referral</option>
                    <option value="advertisement">Advertisement</option>
                </select>
            </div>
            

        
            <div class="mb-4">
                <label class="text-black font-semibold mb-1">More Comments, Feedback, Suggestions</label>
                <textarea name="additional_feedback" rows="3" placeholder="Type here..." class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600"></textarea>
            </div>


            <div class="mb-4">
                <label class="text-black font-semibold mb-1">Would you refer or recommend us to your friends, colleagues, or family?</label>
                <div class="flex space-x-4">
                    <label><input type="radio" name="recommend" value="Yes"> Yes</label>
                    <label><input type="radio" name="recommend" value="No"> No</label>
                </div>
            </div>

    
            <div class="mb-4">
                <label class="block text-black font-semibold mb-1">Would you like to receive promotional emails from us?</label>
                <div class="flex space-x-4">
                    <label><input type="radio" name="promo_emails" value="Yes"> Yes</label>
                    <label><input type="radio" name="promo_emails" value="No"> No</label>
                </div>
            </div>

        
            <div class="text-center">
                <button type="submit" class="bg-blue-500 px-6 py-2 rounded-md font-bold hover:bg-blue-600 transition">
                    Submit Feedback
                </button>
            </div>
        </form>
    </div>

    <footer class="text-center mt-8 py-4 bg-gray-700 text-white">
        <p>&copy; 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
      </footer>

    <!-- JavaScript for 10-star rating system -->
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
        const starContainer = document.getElementById("starRating");
        const ratingInput = document.getElementById("ratingValue");
    
        for (let i = 1; i <= 10; i++) {
            let star = document.createElement("span");
            star.innerHTML = "&#9733;";
            star.dataset.value = i * 0.5;
            star.classList.add("text-white", "cursor-pointer", "text-2xl");
    
            star.onclick = function () {
                ratingInput.value = this.dataset.value;
                
                // Reset all stars to white
                document.querySelectorAll("#starRating span").forEach(s => s.classList.remove("text-yellow-500"));
                document.querySelectorAll("#starRating span").forEach(s => s.classList.add("text-white"));
    
                // Make selected star and all previous stars golden
                for (let j = 0; j < this.dataset.value * 2; j++) {
                    document.querySelectorAll("#starRating span")[j].classList.add("text-yellow-500");
                }
            };
    
            starContainer.appendChild(star);
        }
    </script>
    

</body>
</html>
<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "travel";
$port = 3306; // MySQL port in XAMPP //for aviral

$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guide_fname = $_POST["guide_fname"];
    $trip_name = $_POST["trip_name"];
    $trip_destination = $_POST["trip_destination"];
    $departure_date = $_POST["departure_date"];
    
    // Ratings
    $accommodation_rating = $_POST["accommodation"] ?? "Not Rated";
    $transport_rating = $_POST["transport"] ?? "Not Rated";
    $food_rating = $_POST["food"] ?? "Not Rated";
    $places_rating = $_POST["places"] ?? "Not Rated";
    $professionalism_rating = $_POST["professionalism"] ?? "Not Rated";
    $costs_rating = $_POST["costs"] ?? "Not Rated";
    $communication_rating = $_POST["ease_of_communication"] ?? "Not Rated";
    $safety_rating = $_POST["safety"] ?? "Not Rated";
    $driver_rating = $_POST["driver"] ?? "Not Rated";
    $tour_guide_rating = $_POST["tour_guide"] ?? "Not Rated";
    $knowledge_rating = $_POST["knowledge"] ?? "Not Rated";
    $registration_rating = $_POST["registration_process"] ?? "Not Rated";
    $payment_rating = $_POST["payment_process"] ?? "Not Rated";

    // Overall rating
    $overall_rating = isset($_POST["overall_rating"]) ? floatval($_POST["overall_rating"]) : 0;

    // Text fields
    $places_enjoyed = $_POST["places_enjoyed"];
    $places_not_enjoyed = $_POST["places_not_enjoyed"];
    $places_next = $_POST["places_next"];
    $heard_about_us = $_POST["heard_about_us"];
    $additional_feedback = $_POST["additional_feedback"];
    $recommend = $_POST["recommend"] ?? "No";
    $promo_emails = $_POST["promo_emails"] ?? "No";

    // Insert into database
    $sql = "INSERT INTO feedback (
                guide_fname, trip_name, trip_destination, departure_date,
                accommodation_rating, transport_rating, food_rating, places_rating,
                professionalism_rating, costs_rating, communication_rating, safety_rating,
                driver_rating, tour_guide_rating, knowledge_rating, registration_rating, payment_rating,
                overall_rating, places_enjoyed, places_not_enjoyed, places_next,
                heard_about_us, additional_feedback, recommend, promo_emails
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssssssssssdsssssss",
        $guide_fname, $trip_name, $trip_destination, $departure_date,
        $accommodation_rating, $transport_rating, $food_rating, $places_rating,
        $professionalism_rating, $costs_rating, $communication_rating, $safety_rating,
        $driver_rating, $tour_guide_rating, $knowledge_rating, $registration_rating, $payment_rating,
        $overall_rating, $places_enjoyed, $places_not_enjoyed, $places_next,
        $heard_about_us, $additional_feedback, $recommend, $promo_emails
    );

    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully!'); window.location.href='feedback.php';</script>";
    } else {
        echo "<script>alert('Error submitting feedback!'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
