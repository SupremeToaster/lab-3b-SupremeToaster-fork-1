<?php
$servername = "mariadb";  // MySQL service name in docker-compose.yml
$username = "SupremeToaster";  // Username from .env file
$password = "ilostmy1sthtc~";  // Password from .env file
$dbname = "lab_3";  // Database name from .env file

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    error_log("Database connected successfully");
}
?>
