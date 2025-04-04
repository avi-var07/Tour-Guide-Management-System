<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "travel"; 
$port = 3306; 

define('SMTP_USER', 'aviralvarshney07@gmail.com');
define('SMTP_PASS', 'dzbj qcar iihw lbga');


$conn = new mysqli($servername, $username, $password, $dbname, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>
