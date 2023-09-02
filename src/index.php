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

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND done = 0 ORDER BY date ASC");
if ($stmt === false) {
    error_log("Debug: Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Log the number of tasks fetched
error_log("Debug: Number of tasks fetched: " . $result->num_rows);


function echoTask($task) {
    $checkedStatus = $task['done'] ? "checked" : "";
    $checkedClass = $task['done'] ? "task-checked" : "";
    
    echo "<li class='task' id='task-{$task['id']}'>";
    echo "<input type='checkbox' class='task-done checkbox-icon' $checkedStatus onclick='updateTask({$task['id']})' />";
    echo "<span class='task-description $checkedClass'>{$task['text']}</span>";
    echo "<span class='class-date'>{$task['date']}</span>";
    echo "<button type='button' class='task-delete material-icon' onclick='deleteTask({$task['id']})'>backspace</button>";
    echo "</li>";
}
?>
