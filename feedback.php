<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tour Feedback Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .dropdown-transition {
            transition: all 0.3s ease;
            transform-origin: top;
        }
        .scale-in {
            animation: scaleIn 0.3s ease forwards;
        }
        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .hover-lift {
            transition: transform 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-3px);
        }
        .star-animation {
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .star-animation:hover {
            transform: scale(1.2);
        }
        .gradient-background {
            background-image: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            background-attachment: fixed;
        }
    </style>
</head>
<body class="text-white gradient-background min-h-screen">
<nav class="fixed top-0 left-0 right-0 z-50 flex justify-between items-center bg-gradient-to-r from-blue-900 to-indigo-800 py-4 px-6 shadow-lg">
    <a href="mainPage.php" class="text-2xl font-bold text-white tracking-wide flex items-center hover-lift">
        <span class="text-yellow-400 mr-1">✈️</span> Tour Operator
    </a>
    
    <ul class="flex items-center space-x-6">
        <li><a href="mainPage.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">Home</a></li>
        <li><a href="destination.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">Destinations</a></li>
        <li><a href="feedback.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">Feedback</a></li>
        
        <li class="relative group">
            <button id="dropdownBtn" class="text-white font-medium cursor-pointer focus:outline-none flex items-center hover:text-yellow-300 transition-colors">
                Bookings
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="dropdownMenu" class="absolute hidden bg-white text-gray-800 shadow-xl rounded-lg mt-2 w-64 z-50 py-2 border border-gray-100 dropdown-transition scale-in">
                <li><a href="guidebooking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">👤</span> Hire a Guide</a></li>
                <li><a href="booking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">🏞️</span> Tour Booking</a></li>
                <li><a href="userDashboard.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">📊</span> User Dashboard</a></li>
                <li><a href="packageManagement.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">📦</span> Tour Package Management</a></li>
                <li><a href="customTour.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">✏️</span> Custom Tour Planning</a></li>
            </ul>
        </li>
        <li><a href="about.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift">About</a></li>
        
        
        <?php if (isset($_SESSION['username'])): ?>
        <li class="relative group ml-4">
            <button id="userDropdownBtn" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-colors flex items-center">
                <span class="mr-1">👤</span>
                <?php echo $_SESSION['username']; ?>
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="userDropdownMenu" class="absolute hidden right-0 bg-white text-gray-800 shadow-xl rounded-lg mt-2 w-48 z-50 py-2 border border-gray-100 group-hover:block">
                <li><a href="userDashboard.php" class="block px-4 py-2 hover:bg-blue-50">My Profile</a></li>
                <li><a href="booking.php" class="block px-4 py-2 hover:bg-blue-50">My Bookings</a></li>
                <li><hr class="my-1 border-gray-200"></li>
                <li><a href="logout.php" class="block px-4 py-2 hover:bg-red-50 text-red-600 font-medium">Logout</a></li>
            </ul>
        </li>
        <?php else: ?>
        <li class="ml-4">
            <a href="signup.php" class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-5 py-2 rounded-full transition-colors shadow-md hover:shadow-lg hover-lift">
                Login / Sign Up
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container mx-auto px-4 py-10 pt-24 animate-fadeIn">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-yellow-400 mb-3">Tour Feedback Form</h1>
        <p class="text-lg text-blue-300 max-w-lg mx-auto">We value your opinion! Please share your experience to help us improve our services.</p>
    </div>

    <form name='feedbackForm' method="POST" action="feedback.php" class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-xl border-t-4 border-blue-600 scale-in">
        <!-- Tour Guide Name -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Tour Guide Name</label>
            <div class="flex space-x-4">
                <input type="text" name="guide_fname" placeholder="Name" required class="w-full px-4 py-3 rounded-lg bg-blue-50 text-gray-800 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <!-- Trip Name -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Trip Name</label>
            <input type="text" name="trip_name" placeholder="Trip Name" required class="w-full px-4 py-3 rounded-lg bg-blue-50 text-gray-800 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Trip Destination -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Trip Destination</label>
            <input type="text" name="trip_destination" placeholder="Trip Destination" required class="w-full px-4 py-3 rounded-lg bg-blue-50 text-gray-800 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        
        <!-- Departure Date -->
        <div class="mb-8">
            <label class="block text-gray-700 font-semibold mb-2">Trip Departure Date</label>
            <input type="date" name="departure_date" required class="w-full px-4 py-3 rounded-lg bg-blue-50 text-gray-800 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-bold text-blue-700 mb-4">Rate Your Experience</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="p-3 border border-blue-500">Criteria</th>
                            <th class="p-3 border border-blue-500">Excellent</th>
                            <th class="p-3 border border-blue-500">Satisfactory</th>
                            <th class="p-3 border border-blue-500">Needs Improvement</th>
                            <th class="p-3 border border-blue-500">Not Satisfied</th>
                        </tr>
                    </thead>
                    <tbody>
                    <script>
                        let criteria = ["Accommodation", "Transport", "Food", "Places", "Professionalism", "Costs", "Ease of Communication", "Safety", "Driver", "Tour Guide", "Knowledge", "Registration Process", "Payment Process"];
                        document.write(criteria.map((c, i) => `
                            <tr class="${i % 2 === 0 ? 'bg-blue-50' : 'bg-white'}">
                                <td class="border border-blue-200 p-3 font-medium text-gray-700">${c}</td>
                                ${["Excellent", "Satisfactory", "Needs Improvement", "Not Satisfied"].map(val => `
                                    <td class="border border-blue-200 p-3">
                                        <input type="radio" name="${c.toLowerCase().replace(/\s+/g, '_')}" value="${val}" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    </td>
                                `).join('')}
                            </tr>
                        `).join(''));
                    </script>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">What is your overall rating of the tour experience?</label>
            <div id="starRating" class="flex space-x-1 text-gray-300 text-3xl cursor-pointer">
                <span class="star-animation">★</span>
                <span class="star-animation">★</span>
                <span class="star-animation">★</span>
                <span class="star-animation">★</span>
                <span class="star-animation">★</span>
            </div>
            <input type="hidden" name="overall_rating" id="ratingValue">
        </div>

        <div class="bg-green-50 p-6 rounded-lg mb-8 hover:shadow-md transition-all duration-300">
            <h3 class="text-xl font-bold text-green-700 mb-4">Your Favorite Places</h3>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">What were the places you enjoyed during this tour?</label>
                <textarea name="places_enjoyed" rows="3" placeholder="Tell us about the highlights..." required
                    class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 border border-green-200 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">What were the places you did not enjoy during this tour?</label>
                <textarea name="places_not_enjoyed" rows="3" placeholder="Any disappointments?"
                    class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 border border-green-200 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
            </div>

            <div class="mb-2">
                <label class="block text-gray-700 font-semibold mb-2">What places would you like to visit next?</label>
                <textarea name="places_next" rows="3" placeholder="Your dream destinations..."
                    class="w-full px-4 py-3 rounded-lg bg-white text-gray-800 border border-green-200 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
            </div>
        </div>
    
        <div class="mb-6">
            <label for="heard_about_us" class="block text-gray-700 font-semibold mb-2">How did you hear about us?</label>
            <select name="heard_about_us" id="heard_about_us" class="w-full px-4 py-3 rounded-lg bg-blue-50 text-gray-800 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="" disabled selected class="text-gray-500">Please Select</option>
                <option value="social_media">Social Media</option>
                <option value="friend_referral">Friend Referral</option>
                <option value="advertisement">Advertisement</option>
            </select>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">More Comments, Feedback, Suggestions</label>
            <textarea name="additional_feedback" rows="4" placeholder="Please share any additional thoughts..." 
                class="w-full px-4 py-3 rounded-lg bg-blue-50 text-gray-800 border border-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-blue-50 p-4 rounded-lg hover:shadow-md transition-all duration-300">
                <label class="block text-gray-700 font-semibold mb-3">Would you refer or recommend us to your friends, colleagues, or family?</label>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="recommend" value="Yes" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Yes</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="recommend" value="No" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-gray-700">No</span>
                    </label>
                </div>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg hover:shadow-md transition-all duration-300">
                <label class="block text-gray-700 font-semibold mb-3">Would you like to receive promotional emails from us?</label>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="promo_emails" value="Yes" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Yes</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="promo_emails" value="No" class="w-5 h-5 text-blue-600">
                        <span class="ml-2 text-gray-700">No</span>
                    </label>
                </div>
            </div>
        </div>
    
        <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg px-8 py-3 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-xl">
                Submit Feedback
            </button>
        </div>
    </form>
    
    <div class="text-center mt-8 text-blue-300">
        <p>Thank you for taking the time to share your feedback!</p>
    </div>
</div>

<footer class="bg-gradient-to-b from-gray-800 to-gray-900 text-white pt-12 pb-6">
    <div class="container mx-auto px-4">
        <!-- Top Section with Logo and Quick Links -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10">
            <div class="flex items-center mb-6 md:mb-0">
                <span class="text-2xl font-bold text-white mr-2">✈️</span>
                <h2 class="text-2xl font-bold">Tour<span class="text-yellow-400">Operator</span></h2>
            </div>
            
            <div class="flex space-x-4">
                <a href="https://www.instagram.com/S_iddharth73" target="_blank" class="bg-gray-700 hover:bg-pink-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fab fa-instagram text-white"></i>
                </a>
                <a href="https://x.com/" target="_blank" class="bg-gray-700 hover:bg-blue-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fab fa-twitter text-white"></i>
                </a>
                <a href="mailto:aviralvarshney07@gmail.com" class="bg-gray-700 hover:bg-yellow-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fas fa-envelope text-white"></i>
                </a>
                <a href="#" class="bg-gray-700 hover:bg-blue-600 p-2 rounded-full transition-colors duration-300">
                    <i class="fab fa-facebook text-white"></i>
                </a>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="border-b border-gray-700 mb-8"></div>
        
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Explore Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-compass text-white"></i>
                    </span>
                    Explore
                </h3>
                <ul class="space-y-3">
                    <li><a href="mainPage.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Home
                    </a></li>
                    <li><a href="destination.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Destinations
                    </a></li>
                    <li><a href="guidebooking.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Hire a Guide
                    </a></li>
                    <li><a href="booking.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Tour Booking
                    </a></li>
                    <li><a href="customTour.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Custom Tour Planning
                    </a></li>
                </ul>
            </div>
            
            <!-- Account Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-green-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-user text-white"></i>
                    </span>
                    Account
                </h3>
                <ul class="space-y-3">
                    <li><a href="userDashboard.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>User Dashboard
                    </a></li>
                    <li><a href="packageManagement.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Package Management
                    </a></li>
                    <li><a href="feedback.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Feedback
                    </a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="logout.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Logout
                        </a></li>
                    <?php else: ?>
                        <li><a href="signup.php" class="text-gray-300 hover:text-yellow-400 flex items-center transition-colors duration-200">
                            <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>Login
                        </a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <!-- Contact Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-yellow-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-phone text-white"></i>
                    </span>
                    Contact
                </h3>
                <ul class="space-y-3">
                    <li class="text-gray-300 flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-yellow-400"></i>
                        <span>Tour Operator | Jalandhar, Punjab</span>
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-envelope mr-3 text-yellow-400"></i>
                        <a href="mailto:aviralvarshney07@gmail.com" class="hover:text-yellow-400 transition-colors duration-200">teamTourOperator@gmail.com</a>
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-phone-alt mr-3 text-yellow-400"></i>
                        <span>+91 9876543210</span>
                    </li>
                    <li class="text-gray-300 flex items-center">
                    <i class="fas fa-chevron-right text-xs mr-2 text-yellow-400"></i>
                        <span><a href="about.php">About Us</a></span>
                    </li>
                </ul>
            </div>
            
            <!-- Newsletter Section -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-5 flex items-center">
                    <span class="bg-purple-600 w-8 h-8 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-envelope-open text-white"></i>
                    </span>
                    Newsletter
                </h3>
                <p class="text-gray-300 mb-4">Subscribe to our newsletter for exclusive travel deals and updates.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email address" class="bg-gray-700 text-white px-4 py-2 rounded-l-lg focus:outline-none flex-grow">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-r-lg transition-colors duration-200">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Bottom Section with Copyright -->
        <div class="mt-12 pt-6 border-t border-gray-700 text-center">
            <p class="text-gray-400 text-sm">© 2025 Tour Operator. All rights reserved.</p>
            
        </div>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {
    
    // Booking dropdown functionality
    const dropdownBtn = document.getElementById("dropdownBtn");
    const dropdownMenu = document.getElementById("dropdownMenu");
    
    if (dropdownBtn && dropdownMenu) {
        // Show/hide on click
        dropdownBtn.addEventListener("click", function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle("hidden");
            
            // Rotate arrow
            const arrow = dropdownBtn.querySelector("svg");
            arrow.classList.toggle("rotate-180");
        });
        // Hide dropdown when clicking elsewhere
        document.addEventListener("click", function(e) {
            if (!dropdownBtn.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
                dropdownBtn.querySelector("svg").classList.remove("rotate-180");
            }
        });
    }
    
    // User dropdown functionality
    const userDropdownBtn = document.getElementById("userDropdownBtn");
    const userDropdownMenu = document.getElementById("userDropdownMenu");
    
    if (userDropdownBtn && userDropdownMenu) {
        // Show/hide on click
        userDropdownBtn.addEventListener("click", function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle("hidden");
            
            // Rotate arrow
            const arrow = userDropdownBtn.querySelector("svg");
            arrow.classList.toggle("rotate-180");
        });
        
        // Hide dropdown when clicking elsewhere
        document.addEventListener("click", function(e) {
            if (!userDropdownBtn.contains(e.target)) {
                userDropdownMenu.classList.add("hidden");
                userDropdownBtn.querySelector("svg").classList.remove("rotate-180");
            }
        });
    }
    
    // Star rating functionality
    const stars = document.querySelectorAll('#starRating span');
    const ratingValue = document.getElementById('ratingValue');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = index + 1;
            ratingValue.value = rating;
            
            // Reset all stars
            stars.forEach((s, i) => {
                s.style.color = i < rating ? '#FFD700' : '#e2e8f0';
            });
        });
        
        // Hover effects
        star.addEventListener('mouseover', () => {
            const rating = index + 1;
            
            stars.forEach((s, i) => {
                s.style.color = i < rating ? '#FFD700' : '#e2e8f0';
            });
        });
        
        star.addEventListener('mouseout', () => {
            const currentRating = ratingValue.value || 0;
            
            stars.forEach((s, i) => {
                s.style.color = i < currentRating ? '#FFD700' : '#e2e8f0';
            });
        });
    });
    
    // Form validation
    const form = document.querySelector('form[name="feedbackForm"]');
    
    form.addEventListener('submit', function(e) {
        // Get required criteria fields
        const criteria = ["accommodation", "transport", "food", "places", "professionalism", 
                         "costs", "ease_of_communication", "safety", "driver", "tour_guide", 
                         "knowledge", "registration_process", "payment_process"];
        
        let isFormValid = true;
        
        // Check if any criteria is not selected
        criteria.forEach(item => {
            const selected = document.querySelector(`input[name="${item}"]:checked`);
            if (!selected) {
                isFormValid = false;
            }
        });
        
        // Check if overall rating is provided
        if (!ratingValue.value) {
            isFormValid = false;
        }
        
        // Check if recommend and promo_emails options are selected
        const recommendSelected = document.querySelector('input[name="recommend"]:checked');
        const promoEmailsSelected = document.querySelector('input[name="promo_emails"]:checked');
        
        if (!recommendSelected || !promoEmailsSelected) {
            isFormValid = false;
        }
        
        if (!isFormValid) {
            e.preventDefault();
            alert('Please complete all required fields before submitting.');
        }
    });
    
    // Animate form elements on scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.hover-lift');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run on initial load
});
</script>
</body>
</html>