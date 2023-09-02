$(document).ready(function () {
  // Function to update task status
  // Event handler for the filter checkbox
  $("#cb-filter").change(function () {
    // Perform AJAX request to filter the tasks
    $.post(
      "actions/filter_action.php",
      { filter: this.checked },
      function (data) {
        // Update the UI based on the response
        if (data.success) {
          // Filter the tasks in the UI
          $("#taskContainer").empty(); // Clear the existing tasks
          data.tasks.forEach(function (task) {
            // Assuming 'task' contains the necessary information
            // Add each task to the UI
            $(
              "#taskContainer"
            ).append(/* Your HTML code to represent the task */);
          });
        }
      },
      "json"
    ).catch(function (error) {
      console.log("Error:", error); // Debugging line
    });
  });
});

function updateTask(taskId) {
  $.post(
    "actions/update_action.php",
    { id: taskId },
    function (data) {
      // Update the UI based on the response
      if (data.success) {
        // Toggle the task's done status in the UI
        $("#task-" + taskId + " .task-description").toggleClass("task-checked");
      }
    },
    "json"
  );
}

// Function to delete a task
function deleteTask(taskId) {
  $.post(
    "actions/delete_action.php",
    { id: taskId },
    function (data) {
      if (data.success) {
        // Remove the task from the UI
        $("#task-" + taskId).remove();
      }
    },
    "json"
  );
}

// Event handler for the sort checkbox
$("#cb-sort").change(function () {
  // Perform AJAX request to sort the tasks
  $.post(
    "actions/sort_action.php",
    { sort: this.checked },
    function (data) {
      // Update the UI based on the response
      if (data.success) {
        // Sort the tasks in the UI
        // (This part can be customized based on how you want to sort the tasks)
      }
    },
    "json"
  );
});

// Fetch tasks from the server
function fetchTasks() {
  fetch("index.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "action=fetch",
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Success:", data); // Log the data on success
      displayTasks(data);
    })
    .catch((error) => {
      console.error("Error:", error); // Log any errors
    });
}
