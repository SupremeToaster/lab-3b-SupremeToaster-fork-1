<?php
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

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirm_password) {
    // Redirect with error
    header("Location: ../views/register.php?error=passwords_do_not_match");
    exit;
}

// Check if username exists
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // Redirect with error
    header("Location: ../views/register.php?error=username_taken");
    exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert new user
$query = "INSERT INTO users (username, password, logged_in) VALUES (?, ?, true)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();

// Set session variables
session_start();
$_SESSION['logged_in'] = 'true';
$_SESSION['username'] = $username;

// Redirect to application
header("Location: ../index.php");
?>