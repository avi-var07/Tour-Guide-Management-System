<?php
session_start();

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


include 'config.php';

// Database Connection
$con = mysqli_connect('localhost', 'root', '', 'travel', 3306);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle OTP Sending
if (isset($_POST['send_otp'])) {
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['pincode'] = $_POST['pincode'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['confirm_password'] = $_POST['confirm_password'];
    $_SESSION['terms'] = isset($_POST['terms']) ? 1 : 0;
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $_SESSION['otp_time'] = time();


    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = password_hash($otp, PASSWORD_DEFAULT);
    
    
    
    // Send OTP via email
    $mail = new PHPMailer(true);
    try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'aviralvarshney07@gmail.com'; 
    $mail->Password = 'dzbj qcar iihw lbga'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
 


    $mail->setFrom('aviralvarshney07@gmail.com', 'Aviral Varshney');
    $mail->addAddress($email);
    $mail->Subject = "Your OTP for Signup";
    $mail->Body = "Your OTP is: " . $otp;
   
    
    $mail->send();
    $_SESSION['otp_sent'] = "OTP sent successfully!";
} catch (Exception $e) {
    $_SESSION['error'] = "OTP sending failed: " . $mail->ErrorInfo;
}

}
// Handle Signup
if (isset($_POST['signup'])) {
    if (!isset($_POST['terms'])) {
        $_SESSION['error'] = "You must agree to the Terms and Conditions!";
    }

    $firstname = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $pincode = trim($_POST['pincode']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $otp_entered = $_POST['otp'];
    
    if (time() - $_SESSION['otp_time'] > 300) {
        $_SESSION['error'] = "OTP expired!";
        header("Location: signup.php");
        exit();
    } elseif (!password_verify($otp_entered, $_SESSION['otp'])) {
        $_SESSION['error'] = "Invalid OTP!";
        header("Location: signup.php");
        exit();
    }
    
    // Store values in session to retain them on form submission failure
    $_SESSION['name'] = $firstname;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['dob'] = $dob;
    $_SESSION['pincode'] = $pincode;
    $_SESSION['city'] = $city;
    $_SESSION['state'] = $state;
    $_SESSION['password'] = $password;
    $_SESSION['confirm_password'] = $confirm_password;
   
    
    // Validate OTP
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
    } else {
        // Check if email exists
        $stmt = mysqli_prepare($con, "SELECT * FROM `customer` WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = "Email is already registered!";
        } else {
            // Hash Password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert Data
            $stmt = mysqli_prepare($con, "INSERT INTO `customer` (fname, email, phone, dob, pincode, city, state, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssssss", $firstname, $email, $phone, $dob, $pincode, $city, $state, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "Signup Successful! Please login.";
                header("Location: signin.php");
                exit();
            } else {
                $_SESSION['error'] = "Signup failed. Please try again!";
            }
        }
    }
    if (isset($_POST['signup'])) {
        // Form validation aur database insertion yaha ho raha hai...
    
        if ($signup_successful) {  // If signup is successful
            unset($_SESSION['name'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['dob'], $_SESSION['pincode'], $_SESSION['city'], $_SESSION['state'],$_SESSION['password'], $_SESSION['confirm_password']);
            header("Location: signin.php");
            exit();
        }
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function fetchLocation() {
            let pincode = document.getElementById("pincode").value;
            let cityField = document.getElementById("city");
            let stateField = document.getElementById("state");

            if (pincode.length === 6) {
                fetch(`https://api.postalpincode.in/pincode/${pincode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data[0].Status === "Success") {
                            cityField.value = data[0].PostOffice[0].District;
                            stateField.value = data[0].PostOffice[0].State;
                        } else {
                            cityField.value = "";
                            stateField.value = "";
                            alert("Invalid Pincode! Please enter a valid one.");
                        }
                    })
                    .catch(error => console.error("Error fetching location:", error));
            }
        }

        function validateTerms() {
            if (!document.getElementById("terms").checked) {
                alert("You must agree to the Terms and Conditions to sign up.");
                return false;
            }
            return true;
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
</head>
<body>
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

<div class="bg-white p-6 rounded-lg shadow-lg w-[400px] flexbox justify-center items-center mt-20 mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-700">Create an Account</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p class='text-red-500 text-center mb-4'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<p class='text-green-500 text-center mb-4'>".$_SESSION['success']."</p>";
        unset($_SESSION['success']);
    }
    ?>

    <form action="signup.php" method="POST" onsubmit="return validateTerms()">
        <fieldset class="border p-4 rounded-lg">
            <legend class="text-lg text-gray-700">Personal Information</legend>
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-2">
                    <label class="block text-gray-700">Full Name</label>
                    <input type="text" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black">

                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" >
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700">Contact Number</label>
                    <input type="tel" name="phone" pattern="[0-9]{10}" maxlength="10" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black"
                           placeholder="Enter 10-digit number" >
                </div>

                <div>
                    <label class="block text-gray-700">DOB</label>
                    <input type="date" name="dob" value="<?= isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" value="<?= isset($_SESSION['dob']) ? $_SESSION['dob'] : '' ?>">
                </div>

                <div>
                    <label class="block text-gray-700">Pincode</label>
                    <input type="text" id="pincode" name="pincode" required maxlength="6" pattern="[0-9]{6}"
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black"
                           placeholder="Enter Pincode" onkeyup="fetchLocation()" value="<?= isset($_SESSION['pincode']) ? $_SESSION['pincode'] : '' ?>">
                </div>

                <div>
                    <label class="block text-gray-700">City</label>
                    <input type="text" id="city" name="city" readonly value="<?= isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>" required
                           class="w-full px-3 py-2 border rounded-lg bg-gray-200 text-black" >
                </div>

                <div>
                    <label class="block text-gray-700">State</label>
                    <input type="text" id="state" name="state" readonly value="<?= isset($_POST['state']) ? htmlspecialchars($_POST['state']) : ''; ?>" required
                           class="w-full px-3 py-2 border rounded-lg bg-gray-200 text-black" >
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700">Password</label>
                    <input type="password" name="password" value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" >
                </div>

                <div class="col-span-2">
                    <label class="block text-gray-700">Confirm Password</label>
                    <input type="password" name="confirm_password" value="<?= isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : ''; ?>" required 
                           class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" >
                </div>

                <div class="col-span-2 flex items-center">
                    <input type="checkbox" id="terms" name="terms" class="mr-2">
                    <label for="terms" class="text-gray-700 text-sm">I agree to the 
                        <a href="terms.php" class="text-blue-500 underline">Terms and Conditions</a>
                    </label>
                </div>
                <div class="col-span-2">
                
                <button type="submit" name="send_otp" formnovalidate class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Send OTP</button>

            </div>

            <div class="col-span-2">
                <label class="block text-gray-700">Enter OTP</label>
                <input type="text" name="otp" maxlength="6" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black" >
            </div>
            </div>
        </fieldset>

        <button type="submit" name="signup"
                class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Sign Up
        </button>
        <p class="text-center text-gray-700 mt-3">Already have an account? 
            <a href="signin.php" class="text-blue-500 underline">Login</a>
        </p>

    </form>
    
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
</div>

<footer class="text-center mt-8 py-4 bg-gray-700 text-white">
    <p>&copy; 2025 Tour Operator | <a href="https://www.instagram.com/" class="hover:text-pink-400">Instagram</a> | <a href="https://twitter.com/" class="hover:text-blue-400">Twitter</a></p>
  </footer>
</body>
</html>
