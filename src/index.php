<?php
// Start session
session_start();

// Debugging: Log session variables
error_log("Debug: Session logged_in: " . $_SESSION['logged_in']);
error_log("Debug: Session user_id: " . $_SESSION['user_id']);

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 'yes') {
    header("Location: views/login.php");
    exit;
}

include 'db_connection.php';

// Read checkbox states
$sort_by_date = isset($_POST['cb-sort']) ? "ASC" : "DESC";
$filter_completed = isset($_POST['cb-filter']) ? "AND done = 0" : "";

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tasks WHERE user_id = ? $filter_completed ORDER BY date $sort_by_date";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Log the number of tasks fetched
error_log("Debug: Number of tasks fetched: " . $result->num_rows);

// ... (rest of the code remains the same)
?>
