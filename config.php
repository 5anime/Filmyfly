<?php
// config.php
$host = 'localhost';
$username = 'admin-user';
$password = '0123';
$dbname = 'admin-name';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
