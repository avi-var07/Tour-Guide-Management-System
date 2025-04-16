<?php
session_start();
$destinations = include 'destinations_data.php';

// Filter logic
$filtered_destinations = $destinations;
$selected_state = isset($_GET['state']) ? $_GET['state'] : 'All';
$selected_budget = isset($_GET['budget']) ? $_GET['budget'] : 'All';
$selected_type = isset($_GET['type']) ? $_GET['type'] : 'All';
$selected_duration = isset($_GET['duration']) ? $_GET['duration'] : 'All';

if ($selected_state !== 'All' || $selected_budget !== 'All' || $selected_type !== 'All' || $selected_duration !== 'All') {
    $filtered_destinations = array_filter($destinations, function ($dest) use ($selected_state, $selected_budget, $selected_type, $selected_duration) {
        $state_match = $selected_state === 'All' || $dest['state'] === $selected_state;
        $budget_match = $selected_budget === 'All' || $dest['budget'] === $selected_budget;
        $type_match = $selected_type === 'All' || $dest['type'] === $selected_type;
        $duration_match = $selected_duration === 'All' || $dest['duration'] === $selected_duration;
        return $state_match && $budget_match && $type_match && $duration_match;
    });
}

// Get unique values for filters
$states = array_unique(array_column($destinations, 'state'));
$budgets = ['Budget', 'Mid-range', 'Luxury'];
$types = ['Adventure', 'Spiritual', 'Chill', 'Party', 'Offbeat'];
$durations = ['Weekend', '5-day', 'Week-long'];
sort($states);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Destinations | Tour Operator</title>
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }
        .badge {
            display: inline-block;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .filter-container {
            transition: all 0.5s ease;
        }
        .destination-card {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .destination-card.show {
            opacity: 1;
            transform: translateY(0);
        }
        .filter-tag {
            transition: all 0.3s ease;
        }
        .filter-tag:hover {
            transform: scale(1.05);
        }
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        .hero-section {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('images/destination-hero.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .counter {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ffffff;
        }
    </style>
</head>
<body class="text-white bg-gray-900">
<nav class="flex justify-between items-center bg-gradient-to-r from-blue-900 to-indigo-800 py-4 px-6 shadow-lg">
    <a href="mainPage.php" class="text-2xl font-bold text-white tracking-wide flex items-center">
        <span class="text-yellow-400 mr-1">✈️</span> Tour Operator
    </a>
    
    <ul class="flex items-center space-x-6">
        <li><a href="mainPage.php" class="text-white hover:text-yellow-300 transition-colors font-medium">Home</a></li>
        <li><a href="destination.php" class="text-white hover:text-yellow-300 transition-colors font-medium">Destinations</a></li>
        <li><a href="feedback.php" class="text-white hover:text-yellow-300 transition-colors font-medium">Feedback</a></li>
        
        <li class="relative group">
            <button id="dropdownBtn" class="text-white font-medium cursor-pointer focus:outline-none flex items-center hover:text-yellow-300 transition-colors">
                Bookings
                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <ul id="dropdownMenu" class="absolute hidden bg-white text-gray-800 shadow-xl rounded-lg mt-2 w-64 z-50 py-2 border border-gray-100 group-hover:block transform origin-top">
                <li><a href="guidebooking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">👤</span> Hire a Guide</a></li>
                <li><a href="booking.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">🏞️</span> Tour Booking</a></li>
                <li><a href="userDashboard.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">📊</span> User Dashboard</a></li>
                <li><a href="packageManagement.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">📦</span> Tour Package Management</a></li>
                <li><a href="customTour.php" class="block px-4 py-3 hover:bg-blue-50 flex items-center"><span class="text-blue-500 mr-2">✏️</span> Custom Tour Planning</a></li>
            </ul>
        </li>
        <li><a href="about.php" class="text-white hover:text-yellow-300 transition-colors font-medium">About</a></li>
        
        <li>
            <button id="themeToggle" class="ml-4 bg-blue-700 hover:bg-blue-600 text-white p-2 rounded-full transition-colors focus:ring-2 focus:ring-yellow-300 focus:outline-none">
                <img src="theme_icon.png" alt="Theme Toggle" class="h-5 w-5">
            </button>
        </li>
        
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
            <a href="signup.php" class="bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold px-5 py-2 rounded-full transition-colors shadow-md hover:shadow-lg">
                Login / Sign Up
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<!-- Hero Section -->
<div class="hero-section py-20 flex flex-col items-center justify-center animate__animated animate__fadeIn">
    <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">Discover Amazing Places</h1>
    <p class="text-xl text-gray-200 max-w-2xl text-center mb-8">Find your perfect travel experience from our curated collection of breathtaking destinations</p>
    <div class="flex flex-wrap justify-center gap-8 mt-6 mb-10">
        <div class="text-center">
            <span class="counter" id="destinationCounter"><?php echo count($destinations); ?></span>
            <p class="text-yellow-300">Destinations</p>
        </div>
        <div class="text-center">
            <span class="counter" id="stateCounter"><?php echo count($states); ?></span>
            <p class="text-yellow-300">States</p>
        </div>
        <div class="text-center">
            <span class="counter" id="typeCounter"><?php echo count($types); ?></span>
            <p class="text-yellow-300">Experience Types</p>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="container mx-auto px-4 py-8">
    <div class="filter-container bg-gray-800 rounded-xl shadow-2xl p-6 mb-12 animate__animated animate__fadeInUp">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-300">Find Your Perfect Destination</h2>
        <form method="GET" action="destination.php" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="filter-group">
                <label for="state" class="block mb-2 text-lg font-semibold text-blue-400">
                    <i class="fas fa-map-marker-alt mr-2"></i>State
                </label>
                <select name="state" id="state" onchange="this.form.submit()" class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg border-2 border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="All" <?php echo $selected_state === 'All' ? 'selected' : ''; ?>>All States</option>
                    <?php foreach ($states as $state): ?>
                        <option value="<?php echo htmlspecialchars($state); ?>" <?php echo $selected_state === $state ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($state); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="budget" class="block mb-2 text-lg font-semibold text-blue-400">
                    <i class="fas fa-wallet mr-2"></i>Budget
                </label>
                <select name="budget" id="budget" onchange="this.form.submit()" class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg border-2 border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="All" <?php echo $selected_budget === 'All' ? 'selected' : ''; ?>>All Budgets</option>
                    <?php foreach ($budgets as $budget): ?>
                        <option value="<?php echo htmlspecialchars($budget); ?>" <?php echo $selected_budget === $budget ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($budget); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="type" class="block mb-2 text-lg font-semibold text-blue-400">
                    <i class="fas fa-mountain mr-2"></i>Type
                </label>
                <select name="type" id="type" onchange="this.form.submit()" class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg border-2 border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="All" <?php echo $selected_type === 'All' ? 'selected' : ''; ?>>All Types</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo htmlspecialchars($type); ?>" <?php echo $selected_type === $type ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="duration" class="block mb-2 text-lg font-semibold text-blue-400">
                    <i class="fas fa-clock mr-2"></i>Duration
                </label>
                <select name="duration" id="duration" onchange="this.form.submit()" class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg border-2 border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all">
                    <option value="All" <?php echo $selected_duration === 'All' ? 'selected' : ''; ?>>All Durations</option>
                    <?php foreach ($durations as $duration): ?>
                        <option value="<?php echo htmlspecialchars($duration); ?>" <?php echo $selected_duration === $duration ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($duration); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Active Filters Display -->
            <?php if ($selected_state !== 'All' || $selected_budget !== 'All' || $selected_type !== 'All' || $selected_duration !== 'All'): ?>
            <div class="col-span-1 md:col-span-2 lg:col-span-4 mt-4">
                <div class="flex flex-wrap items-center">
                    <span class="text-gray-300 mr-3">Active Filters:</span>
                    <?php if ($selected_state !== 'All'): ?>
                        <a href="?state=All&budget=<?php echo $selected_budget; ?>&type=<?php echo $selected_type; ?>&duration=<?php echo $selected_duration; ?>" class="filter-tag badge bg-blue-600 hover:bg-blue-700 mb-2 flex items-center">
                            <span class="mr-1"><?php echo htmlspecialchars($selected_state); ?></span>
                            <i class="fas fa-times-circle"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($selected_budget !== 'All'): ?>
                        <a href="?state=<?php echo $selected_state; ?>&budget=All&type=<?php echo $selected_type; ?>&duration=<?php echo $selected_duration; ?>" class="filter-tag badge bg-green-600 hover:bg-green-700 mb-2 flex items-center">
                            <span class="mr-1"><?php echo htmlspecialchars($selected_budget); ?></span>
                            <i class="fas fa-times-circle"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($selected_type !== 'All'): ?>
                        <a href="?state=<?php echo $selected_state; ?>&budget=<?php echo $selected_budget; ?>&type=All&duration=<?php echo $selected_duration; ?>" class="filter-tag badge bg-purple-600 hover:bg-purple-700 mb-2 flex items-center">
                            <span class="mr-1"><?php echo htmlspecialchars($selected_type); ?></span>
                            <i class="fas fa-times-circle"></i>
                        </a>
                    <?php endif; ?>
                    <?php if ($selected_duration !== 'All'): ?>
                        <a href="?state=<?php echo $selected_state; ?>&budget=<?php echo $selected_budget; ?>&type=<?php echo $selected_type; ?>&duration=All" class="filter-tag badge bg-yellow-600 hover:bg-yellow-700 mb-2 flex items-center">
                            <span class="mr-1"><?php echo htmlspecialchars($selected_duration); ?></span>
                            <i class="fas fa-times-circle"></i>
                        </a>
                    <?php endif; ?>
                    
                    <a href="destination.php" class="ml-auto text-sm text-yellow-400 hover:text-yellow-300 transition-colors">
                        <i class="fas fa-sync-alt mr-1"></i> Reset All Filters
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Main Content Section -->
<div class="container mx-auto px-4 py-8">
    <?php if (empty($filtered_destinations)): ?>
        <div class="text-center py-12 animate__animated animate__fadeIn">
            <div class="text-6xl mb-6"><i class="far fa-sad-tear"></i></div>
            <h2 class="text-3xl font-bold mb-4">No Destinations Found</h2>
            <p class="text-xl text-gray-400 mb-8">We couldn't find any destinations that match your current filters.</p>
            <a href="destination.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center transition-all">
                <i class="fas fa-sync-alt mr-2"></i>
                Reset Filters
            </a>
        </div>
    <?php else: ?>
        <!-- Result Stats -->
        <div class="mb-8 text-center animate__animated animate__fadeIn">
            <h1 class="text-4xl font-bold mb-2">Our Popular Destinations</h1>
            <p class="text-gray-400">
                Found <span class="text-yellow-400 font-bold"><?php echo count($filtered_destinations); ?></span> amazing places for your next adventure
            </p>
        </div>
        
        <!-- Destinations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($filtered_destinations as $index => $dest): ?>
                <div class="destination-card card-hover rounded-xl overflow-hidden bg-gray-800 shadow-lg">
                    <div class="relative">
                        <img src="<?php echo htmlspecialchars(file_exists($dest['image']) ? $dest['image'] : 'images/destination/default.jpg'); ?>" 
                            alt="<?php echo htmlspecialchars($dest['name']); ?>" 
                            class="w-full h-64 object-cover transition-transform duration-700 hover:scale-110">
                        
                        <div class="absolute top-0 right-0 m-4">
                            <?php
                            // Budget badge color
                            $budgetColor = '';
                            if ($dest['budget'] === 'Budget') $budgetColor = 'bg-green-500';
                            elseif ($dest['budget'] === 'Mid-range') $budgetColor = 'bg-yellow-500';
                            elseif ($dest['budget'] === 'Luxury') $budgetColor = 'bg-purple-500';
                            ?>
                            <span class="badge <?php echo $budgetColor; ?> text-white">
                                <?php echo htmlspecialchars($dest['budget']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($dest['name']); ?></h2>
                            <div class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                        
                        <div class="flex items-center mb-4">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                            <span class="text-gray-400"><?php echo htmlspecialchars($dest['state']); ?></span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-tag text-blue-400 mr-2"></i>
                                <span class="text-gray-300"><?php echo htmlspecialchars($dest['type']); ?></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-blue-400 mr-2"></i>
                                <span class="text-gray-300"><?php echo htmlspecialchars($dest['duration']); ?></span>
                            </div>
                        </div>
                        
                        <form method="GET" action="package_details.php" class="mt-4">
                            <input type="hidden" name="dest_id" value="<?php echo $index; ?>">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition-all flex items-center justify-center group">
                                <span>Explore Destination</span>
                                <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
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

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Dropdown menu functionality
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

        // Theme toggle functionality
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

        // User dropdown functionality
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

        // Animate cards on scroll
        const destCards = document.querySelectorAll('.destination-card');
        
        // Initial check when page loads
        animateCards();
        
        // Check on scroll
        window.addEventListener('scroll', animateCards);
        
        function animateCards() {
            destCards.forEach((card) => {
                const cardTop = card.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (cardTop < windowHeight - 100) {
                    card.classList.add('show');
                }
            });
        }

        // Counter animation
        function animateCounter(id, end) {
            const obj = document.getElementById(id);
            const duration = 2000;
            const start = 0;
            const range = end - start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            let current = start;
            
            const timer = setInterval(function() {
                current += increment;
                obj.textContent = current;
                if (current == end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        // Start counter animations
        animateCounter('destinationCounter', <?php echo count($destinations); ?>);
        animateCounter('stateCounter', <?php echo count($states); ?>);
        animateCounter('typeCounter', <?php echo count($types); ?>);

        // Filter tag hover effects
        const filterTags = document.querySelectorAll('.filter-tag');
        filterTags.forEach(tag => {
            tag.addEventListener('mouseenter', () => {
                tag.querySelector('i').classList.add('fa-spin');
            });
            tag.addEventListener('mouseleave', () => {
                tag.querySelector('i').classList.remove('fa-spin');
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                const scrollPosition = window.pageYOffset;
                heroSection.style.backgroundPositionY = scrollPosition * 0.5 + 'px';
            }
        });

        // Button hover animation for destination cards
        const buttons = document.querySelectorAll('.destination-card button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.classList.add('pulse-animation');
            });
            button.addEventListener('mouseleave', () => {
                button.classList.remove('pulse-animation');
            });
        });
        
        // Image hover effects
        const destImages = document.querySelectorAll('.destination-card img');
        destImages.forEach(img => {
            img.addEventListener('mouseenter', () => {
                img.style.filter = 'brightness(1.1)';
            });
            img.addEventListener('mouseleave', () => {
                img.style.filter = 'brightness(1)';
            });
        });
        
        // Add image lazyloading
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                if (!img.complete) {
                    img.setAttribute('loading', 'lazy');
                }
            });
        }
        
        // Add smooth scroll to page
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId !== '#') {
                    document.querySelector(targetId).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
</body>
</html>