<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../db_connection.php';

    $task_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE tasks SET done = NOT done WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $task_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
}
?>
