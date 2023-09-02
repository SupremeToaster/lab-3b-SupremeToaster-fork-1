// script.js
function deleteTask(taskId) {
  $.post("actions/delete_action.php", { task_id: taskId }, function (data) {
    // Remove the deleted task from the DOM or refresh the task list
    $("#task-" + taskId).remove();
  });
}

function updateTask(taskId) {
  $.post(
    "actions/update_action.php",
    { task_id: taskId },
    function (data) {
      const taskElement = $("#task-" + taskId);
      const descriptionElement = taskElement.find(".task-description");

      if (data.success) {
        // Toggle the 'task-checked' class
        descriptionElement.toggleClass("task-checked");
      } else {
        console.error("Failed to update task:", data.error);
      }
    },
    "json"
  ); // Expect a JSON response
}