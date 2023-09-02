<?php
// ./actions/login_action.php

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");
$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// TODO: Log the user in
// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Check if username exists
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    // Redirect with error
    header("Location: ../views/login.php?error=username_not_found");
    exit;
}

// Get user
$user = $result->fetch_assoc();

// Check if password is correct
if (!password_verify($password, $user['password'])) {
	// Redirect with error
	header("Location: ../views/login.php?error=incorrect_password");
	exit;
}

// Set session variables
session_start();
$_SESSION['logged_in'] = 'yes';
$_SESSION['username'] = $username;
$_SESSION['user_id'] = $user['id'];

// Update logged_in variable in the database
$query = "UPDATE users SET logged_in = true WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();

// Redirect to application
header("Location: ../index.php");

var_dump($password, $user['password']);

?>