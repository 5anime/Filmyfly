<?php
// config.php
$host = 'localhost';
$username = 'admin_hjswiohs';
$password = 'ZzlYeN9j#zyd0_4h';
$dbname = 'admin_hjswiohs';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
