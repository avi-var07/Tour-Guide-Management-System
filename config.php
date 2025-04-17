<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "travel"; 
$port = 3306; 


if (!defined('SMTP_USER')) {
    define('SMTP_USER', 'aviralvarshney07@gmail.com');
}

if (!defined('SMTP_PASS')) {
    define('SMTP_PASS', 'dzbj qcar iihw lbga');
}

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>