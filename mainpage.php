
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kahan Chale - Travel with Us</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    /* Animation styles */
    @keyframes flyPlane {
      0% {
        transform: translateX(-100%) translateY(0);
      }
      50% {
        transform: translateX(50%) translateY(-20px);
      }
      100% {
        transform: translateX(100vw) translateY(0);
      }
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }
    
    .animate-plane {
      animation: flyPlane 15s linear infinite;
    }
    
    .animate-fadeIn {
      animation: fadeIn 0.8s ease-out forwards;
    }
    
    .animate-pulse {
      animation: pulse 2s infinite;
    }
    
    .animate-float {
      animation: float 3s ease-in-out infinite;
    }
    
    .destination-card {
      transition: all 0.3s ease;
    }
    
    .destination-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .gradient-background {
      background-image: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
      background-attachment: fixed;
    }
    
    .cloud {
      position: absolute;
      opacity: 0.8;
      pointer-events: none;
    }
    
    .cloud-1 {
      top: 15%;
      left: 10%;
      animation: float 8s ease-in-out infinite;
    }
    
    .cloud-2 {
      top: 25%;
      right: 15%;
      animation: float 12s ease-in-out infinite;
    }
    
    .star-animation {
      transition: transform 0.2s ease, color 0.2s ease;
    }
    
    .star-animation:hover {
      transform: scale(1.2);
      color: #FFD700;
    }
    
    .hover-lift {
      transition: transform 0.2s ease;
    }
    
    .hover-lift:hover {
      transform: translateY(-3px);
    }
  </style>
</head>
<body class="text-white gradient-background min-h-screen relative overflow-x-hidden">
  <!-- Flying plane animation -->
  <div class="fixed z-50 animate-plane">
    <div class="relative">
      <i class="fas fa-plane text-4xl text-yellow-400"></i>
      <div class="absolute h-1 w-20 bg-gradient-to-r from-transparent via-yellow-200 to-transparent -right-20 top-1/2"></div>
    </div>
  </div>
  
  <!-- Cloud elements -->
  <div class="cloud cloud-1">
    <i class="fas fa-cloud text-gray-200 text-5xl opacity-30"></i>
  </div>
  <div class="cloud cloud-2">
    <i class="fas fa-cloud text-gray-200 text-4xl opacity-30"></i>
  </div>

<nav class="flex justify-between items-center bg-gradient-to-r from-blue-900 to-indigo-800 py-4 px-6 shadow-lg">
    <a href="mainPage.php" class="text-2xl font-bold text-white tracking-wide flex items-center hover-lift">
        <span class="text-yellow-400 mr-1">
        <img src="images/logo/logo.jpg" alt="Logo" class = "rounded-full h-20 w-20">

        </span> 
    </a>
    
    <ul class="flex items-center space-x-6">
        <li><a href="mainPage.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">Home</a></li>
        <li><a href="destination.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">Destinations</a></li>
        <li><a href="feedback.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">Feedback</a></li>
        
        <li class="relative group">
            <button id="dropdownBtn" class="text-white font-medium cursor-pointer focus:outline-none flex items-center hover:text-yellow-300 transition-colors text-2xl">
                Bookings
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="dropdownMenu" class="absolute hidden bg-white text-gray-800 shadow-xl rounded-lg mt-2 w-64 z-50 py-2 border border-gray-100 group-hover:block transform origin-top">
                <li><a href="guidebooking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">👤</span> Hire a Guide</a></li>
                <li><a href="booking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">🏞️</span> Tour Booking</a></li>
                <li><a href="userDashboard.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">📊</span> User Dashboard</a></li>
                <li><a href="packageManagement.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">📦</span> Tour Package Management</a></li>
                <li><a href="customTour.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center text-2xl"><span class="text-blue-500 mr-2">✏️</span> Custom Tour Planning</a></li>
            </ul>
        </li>
        <li><a href="about.php" class="text-white hover:text-yellow-300 transition-colors font-medium hover-lift text-2xl">About</a></li>
        
        
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

<header class="relative">
  <div class="slideshow-container w-full overflow-hidden relative">
    <div class="mySlides w-full hidden">
      <img src="front3.jpg" class="w-full h-[500px] object-cover">
      <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="text-center animate-fadeIn">
          <h1 class="text-5xl font-bold text-white mb-4">Discover New Adventures</h1>
          <p class="text-xl text-white mb-6">Explore the world with our premium tour packages</p>
          <a href="booking.php" class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-8 py-3 rounded-full transition-all hover:shadow-lg animate-pulse">
            Book Now
          </a>
        </div>
      </div>
    </div>
    <div class="mySlides w-full hidden">
      <img src="front2.jpg" class="w-full h-[500px] object-cover">
      <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="text-center animate-fadeIn">
          <h1 class="text-5xl font-bold text-white mb-4">Unforgettable Experiences</h1>
          <p class="text-xl text-white mb-6">Create memories that last a lifetime</p>
          <a href="customTour.php" class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-8 py-3 rounded-full transition-all hover:shadow-lg animate-pulse">
            Plan Your Trip
          </a>
        </div>
      </div>
    </div>
    <div class="mySlides w-full hidden">
      <img src="front1.jpg" class="w-full h-[500px] object-cover">
      <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="text-center animate-fadeIn">
          <h1 class="text-5xl font-bold text-white mb-4">Expert Local Guides</h1>
          <p class="text-xl text-white mb-6">Discover hidden gems with our experienced guides</p>
          <a href="guidebooking.php" class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-8 py-3 rounded-full transition-all hover:shadow-lg animate-pulse">
            Hire a Guide
          </a>
        </div>
      </div>
    </div>
    <button onclick="plusSlides(-1)" class="absolute left-4 top-1/2 text-4xl text-white bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center transition-all z-10">&#10094;</button>
    <button onclick="plusSlides(1)" class="absolute right-4 top-1/2 text-4xl text-white bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center transition-all z-10">&#10095;</button>
  </div>
</header>

<section class="relative py-16 overflow-hidden">
  <!-- Animated elements -->
  <div class="absolute top-10 left-20 text-6xl text-yellow-400 opacity-20 animate-float">
    <i class="fas fa-mountain"></i>
  </div>
  <div class="absolute bottom-10 right-20 text-6xl text-blue-400 opacity-20 animate-float" style="animation-delay: 1s">
    <i class="fas fa-map-marked-alt"></i>
  </div>

  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center mb-16 animate-fadeIn">
      <h2 class="text-4xl font-bold text-white mb-3">
        <span class="inline-block animate-float">✈️</span> 
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-400 to-blue-500">Kahan Chale</span>
      </h2>
      <p class="text-xl text-blue-200 max-w-2xl mx-auto">Your ultimate travel companion for exploring the world's most beautiful destinations</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
      <div class="bg-blue-900 bg-opacity-50 rounded-xl p-6 text-center border-t-4 border-yellow-400 hover:shadow-xl transition-all hover:-translate-y-2 animate-fadeIn" style="animation-delay: 0.2s">
        <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
          <i class="fas fa-map-marked-alt text-blue-900 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Guided Tours</h3>
        <p class="text-blue-200">Expert guides lead you through the best attractions with insightful commentary and local knowledge.</p>
      </div>
      
      <div class="bg-blue-900 bg-opacity-50 rounded-xl p-6 text-center border-t-4 border-yellow-400 hover:shadow-xl transition-all hover:-translate-y-2 animate-fadeIn" style="animation-delay: 0.4s">
        <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
          <i class="fas fa-hotel text-blue-900 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Premium Accommodations</h3>
        <p class="text-blue-200">Stay in carefully selected hotels and resorts that offer comfort, amenities, and excellent service.</p>
      </div>
      
      <div class="bg-blue-900 bg-opacity-50 rounded-xl p-6 text-center border-t-4 border-yellow-400 hover:shadow-xl transition-all hover:-translate-y-2 animate-fadeIn" style="animation-delay: 0.6s">
        <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
          <i class="fas fa-route text-blue-900 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Custom Itineraries</h3>
        <p class="text-blue-200">Create your perfect adventure with our personalized trip planning services tailored to your preferences.</p>
      </div>
    </div>
  </div>
</section>

<section class="py-16 bg-gradient-to-r from-blue-900 to-indigo-900">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-12 text-white">
      <span class="mr-2">🌎</span>Popular Destinations<span class="ml-2">🌎</span>
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <div class="destination-card bg-white bg-opacity-10 rounded-xl overflow-hidden shadow-lg animate-fadeIn" style="animation-delay: 0.2s">
        <div class="relative overflow-hidden">
          <img src="images/destination/jaipur/hawa_mahal.jpg" class="w-full h-60 object-cover transition-transform duration-700 hover:scale-110">
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-xl font-bold text-white">Jaipur</h3>
            <p class="text-yellow-300">The Pink City</p>
          </div>
        </div>
        <div class="p-4">
          <p class="text-gray-300 mb-4">Explore the majestic palaces and vibrant culture of Rajasthan's capital city.</p>
          <div class="flex justify-between items-center">
            <div>
              <span class="text-yellow-400">★★★★★</span>
              <span class="text-sm text-gray-300">(245 reviews)</span>
            </div>
            <a href="destination.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
              Explore
            </a>
          </div>
        </div>
      </div>
      
      <div class="destination-card bg-white bg-opacity-10 rounded-xl overflow-hidden shadow-lg animate-fadeIn" style="animation-delay: 0.4s">
        <div class="relative overflow-hidden">
          <img src="images/destination/leh_ladakh.jpg" class="w-full h-60 object-cover transition-transform duration-700 hover:scale-110">
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-xl font-bold text-white">Ladakh</h3>
            <p class="text-yellow-300">Land of High Passes</p>
          </div>
        </div>
        <div class="p-4">
          <p class="text-gray-300 mb-4">Experience breathtaking landscapes and rich Buddhist culture in the Himalayas.</p>
          <div class="flex justify-between items-center">
            <div>
              <span class="text-yellow-400">★★★★</span>
              <span class="text-sm text-gray-300">(187 reviews)</span>
            </div>
            <a href="destination.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
              Explore
            </a>
          </div>
        </div>
      </div>
      
      <div class="destination-card bg-white bg-opacity-10 rounded-xl overflow-hidden shadow-lg animate-fadeIn" style="animation-delay: 0.6s">
        <div class="relative overflow-hidden">
          <img src="images/destination/varanasi/kashi_vishwanath_temple.webp" class="w-full h-60 object-cover transition-transform duration-700 hover:scale-110">
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-xl font-bold text-white">Varanasi</h3>
            <p class="text-yellow-300">The Spiritual Capital</p>
          </div>
        </div>
        <div class="p-4">
          <p class="text-gray-300 mb-4">Discover the spiritual heart of India along the sacred banks of the Ganges River.</p>
          <div class="flex justify-between items-center">
            <div>
              <span class="text-yellow-400">★★★★★</span>
              <span class="text-sm text-gray-300">(312 reviews)</span>
            </div>
            <a href="destination.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
              Explore
            </a>
          </div>
        </div>
      </div>
      
      <div class="destination-card bg-white bg-opacity-10 rounded-xl overflow-hidden shadow-lg animate-fadeIn" style="animation-delay: 0.8s">
        <div class="relative overflow-hidden">
          <img src="images/destination/auli/auli.jpg" class="w-full h-60 object-cover transition-transform duration-700 hover:scale-110">
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-xl font-bold text-white">Auli</h3>
            <p class="text-yellow-300">Winter Wonderland</p>
          </div>
        </div>
        <div class="p-4">
          <p class="text-gray-300 mb-4">Hit the slopes at India's premier ski destination with panoramic Himalayan views.</p>
          <div class="flex justify-between items-center">
            <div>
              <span class="text-yellow-400">★★★★</span>
              <span class="text-sm text-gray-300">(156 reviews)</span>
            </div>
            <a href="destination.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
              Explore
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="text-center mt-12">
      <a href="destination.php" class="inline-flex items-center bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-8 py-3 rounded-full transition-all hover:shadow-lg">
        View All Destinations
        <i class="fas fa-arrow-right ml-2"></i>
      </a>
    </div>
  </div>
</section>

<section class="py-16 relative overflow-hidden">
  <div class="absolute top-0 left-0 w-full h-full bg-blue-900 opacity-50 z-0"></div>
  <div class="container mx-auto px-4 relative z-10">
    <div class="bg-blue-800 bg-opacity-70 rounded-2xl p-8 md:p-12 shadow-xl border border-blue-700">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="animate-fadeIn">
          <span class="inline-block bg-yellow-500 text-blue-900 px-4 py-1 rounded-full font-bold text-sm mb-4">LIMITED TIME OFFER</span>
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Save 15% on Your Next Adventure!</h2>
          <p class="text-blue-200 mb-6">Book any tour package within the next 30 days and get 15% off. Use promo code <span class="font-bold text-yellow-300">EXPLORE2025</span> at checkout.</p>
          <a href="booking.php" class="inline-flex items-center bg-white hover:bg-yellow-100 text-blue-900 font-bold px-6 py-3 rounded-lg transition-all hover:shadow-lg">
            Book Now
            <i class="fas fa-chevron-right ml-2"></i>
          </a>
        </div>
        <div class="relative animate-float">
          <img src="images/offer.png" class="rounded-lg shadow-lg" alt="Special offer">
          <div class="absolute -top-6 -right-6 bg-yellow-500 text-blue-900 rounded-full w-20 h-20 flex items-center justify-center font-bold text-xl rotate-12 animate-pulse">
            15% OFF
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="bg-gradient-to-b from-gray-800 to-gray-900 text-white pt-12 pb-6">
    <div class="container mx-auto px-4">
      
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
        

        <div class="border-b border-gray-700 mb-8"></div>
        
    
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
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
                        <span>Kahan Chale | Jalandhar, Punjab</span>
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
           
        
      
        <div>
            <p class="text-gray-400 text-sm">© 2025 Kahan Chale. All rights reserved.</p>
            
        </div>
    </div>
</footer>


<script>
    let slideIndex = 0;

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function () {
        showSlides();

        // Dropdown: Main Menu
        const dropdownBtn = document.getElementById('dropdownBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent window click from triggering
                dropdownMenu.classList.toggle('hidden');
            });
        }

        // Dropdown: User Menu
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userDropdownBtn && userDropdownMenu) {
            userDropdownBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                userDropdownMenu.classList.toggle('hidden');
            });
        }

        // Close dropdowns on outside click
        window.addEventListener('click', function () {
            if (dropdownMenu) dropdownMenu.classList.add('hidden');
            if (userDropdownMenu) userDropdownMenu.classList.add('hidden');
        });
    });

    // Auto slideshow
    function showSlides() {
        let slides = document.getElementsByClassName("mySlides");

        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }

        if (slides.length > 0) {
            slides[slideIndex - 1].style.display = "block";
        }

        setTimeout(showSlides, 5000);
    }

    // Manual navigation
    function plusSlides(n) {
        showSlideManual(slideIndex + n);
    }

    function showSlideManual(n) {
        let slides = document.getElementsByClassName("mySlides");

        if (n > slides.length) {
            slideIndex = 1;
        } else if (n < 1) {
            slideIndex = slides.length;
        } else {
            slideIndex = n;
        }

        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        if (slides.length > 0) {
            slides[slideIndex - 1].style.display = "block";
        }
    }
</script>

</script>
</body>
</html>