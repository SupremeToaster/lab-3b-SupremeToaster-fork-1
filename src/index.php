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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Lab-3A</title>
</head>
<body>
  <nav class="navbar">
    <a href="https://707d8d6bdb434516a0857a9cc637bec2.vfs.cloud9.us-west-1.amazonaws.com/_static/public_html/portfoliolab/home.html">My Resume</a>
    <a href="actions/logout_action.php">Log Out</a>
  </nav>
  <h1>To-Do List</h1>
  <input type="checkbox" class="toggle-switch" id="cb-sort" /><label for="cb-sort">Sort by date</label>
  <input type="checkbox" class="toggle-switch" id="cb-filter" /><label for="cb-filter">Filter completed tasks</label>
  <ul id="taskContainer" class="tasklist">
    <?php
    while ($row = $result->fetch_assoc()) {
        echoTask($row);
    }
    ?>
  </ul>
  <form class="form-create-task" action="actions/create_action.php" method="post">
    <input type="text" name="text" required class="my-input" /><br>
    <input type="date" name="date" required class="my-input" /><br>
    <button class="button-styled">Create Task</button><br>
  </form>
  <script src="js/script.js"></script>
</body>
</html>
