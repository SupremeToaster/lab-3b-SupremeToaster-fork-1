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

/*
class Task {
  constructor({ text, date, done, id }) {
    // HINT This method is the constructor. In C++, this would be
    // the Task() method. The curly braces inside the constructor is // a JavaScript syntax that is called 'deconstruction'. This
    // means the constructor will ask for an object
    // (`{i: 'am', an: 'object'}`) with the parameters `text`,
    // `date`, `done`, and `id`. This will make it easier to
    // convert it from the local storage database we will set up.
    this.text = text;
    this.date = date;
    this.done = done;
    this.id = id;
  }

  toHTML() {
    const checkedStatus = this.done ? "checked" : "";
    const checkedClass = this.done ? "task-checked" : "";
    const prettyDate = this.prettyDate();

    const html = `
    <li class="task">
        <input type="checkbox" class="task-done checkbox-icon" ${checkedStatus} onclick="updateTask(${this.id})" />
        <span class="task-description ${checkedClass}"></span> <!-- Removed text here -->
        <span class="class-date">${prettyDate}</span>
        <button class="task-delete material-icon" onclick="deleteTask(${this.id})">backspace</button>
    </li>
    `;
    return html;
  }

  prettyDate() {
    const dateParts = this.date.split("-");
    const prettyDate = `${dateParts[1]}/${dateParts[2]}/${dateParts[0]}`;
    return prettyDate;
  }

  toggle() {
    this.done = !this.done;
    console.log(`Toggle done status: ${this.done}`);
  }
}

//set up the event listeners for the text and date fields
const descriptionInput = document.querySelector('input[name="description"]');
const dateInput = document.querySelector('input[name="date"]');

function loadFormData() {
  let formData = localStorage.getItem("formData");
  if (formData) {
    formData = JSON.parse(formData);
    descriptionInput.value = formData.description || "";
    dateInput.value = formData.date || "";
  }
}
loadFormData(); // Call this function when the script runs

let tasks = [];
tasks = readStorage();

function on_submit(event) {
  event.preventDefault(); // Prevent the default form submission behavior

  // Get the form input values
  const descriptionInput = document.querySelector('input[name="description"]');
  const dateInput = document.querySelector('input[name="date"]');
  const description = descriptionInput.value;
  const date = dateInput.value;

  // Call the createTask function with the input values
  createTask(description, date);

  // Reset the form
  descriptionInput.value = "";
  dateInput.value = "";
  localStorage.removeItem("formData");
}
document
  .querySelector(".form-create-task")
  .addEventListener("submit", on_submit);

function updateStorage() {
  localStorage.setItem("tasks", JSON.stringify(tasks));
}

function readStorage() {
  let jsonString = localStorage.getItem("tasks");
  let result = JSON.parse(jsonString) || [];
  result = result.map((taskData) => new Task(taskData));
  return result;
}

function createTask(text, date) {
  let id = Date.now();
  let task = new Task({ text, date, done: false, id });
  tasks.push(task);
  updateStorage();
  readAndDisplayTasks();
}

function readAndDisplayTasks() {
  let displayTasks = [...tasks]; // Make a copy of the tasks

  // Sort by date if necessary
  if (document.getElementById("cb-sort").checked) {
    displayTasks.sort((a, b) => new Date(a.date) - new Date(b.date));
  }

  // Filter out completed tasks if necessary
  if (document.getElementById("cb-filter").checked) {
    displayTasks = displayTasks.filter((task) => !task.done);
  }

  console.log("Tasks from local storage:", displayTasks);
  let taskContainer = document.getElementById("taskContainer");
  taskContainer.innerHTML = ""; // Clear the existing tasks

  const fragment = document.createDocumentFragment();

  displayTasks.forEach((task) => {
    const taskElement = document.createElement("li");
    taskElement.innerHTML = task.toHTML();
    const descriptionElement = taskElement.querySelector(".task-description");
    descriptionElement.textContent = task.text; // Set the text content directly
    fragment.appendChild(taskElement);
  });

  taskContainer.appendChild(fragment); // Append the fragment to the task container
}

function updateTask(id) {
  let task = tasks.find((task) => task.id === id);
  if (task) {
    task.toggle();
    updateStorage();
    readAndDisplayTasks();
  }
}

function deleteTask(id) {
  tasks = tasks.filter((task) => task.id !== id);
  updateStorage();
  readAndDisplayTasks();
}

descriptionInput.addEventListener("input", saveFormData);
dateInput.addEventListener("input", saveFormData);

function saveFormData() {
  const formData = {
    description: descriptionInput.value,
    date: dateInput.value,
  };
  localStorage.setItem("formData", JSON.stringify(formData));
}
document.getElementById("cb-sort").addEventListener("change", function () {
  readAndDisplayTasks(); // Call readAndDisplayTasks when the checkbox state changes
});
document.getElementById("cb-filter").addEventListener("change", function () {
  readAndDisplayTasks();
});

readAndDisplayTasks();
*/
