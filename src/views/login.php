<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Add an appropriate title in this tag -->
  <title>Login</title>
  <!-- Links to stylesheets -->
  <link rel="stylesheet" href="/css/style.css">
</head>

<body>
  <nav>Simple To-Do - Log in page</nav>
  <form action="/actions/login_action.php" method="post">
    <div class="input-container">
      <div class="input-row">
        <label for="username">Username:</label>
      </div>
      <div class="input-row">
        <input type="text" class="input-row" placeholder="exampleNoEmailNeeded" id="username" name="username" required>
      </div>
      <div class="input-row">
        <label for="password">Password:</label>
      </div>
      <div class="input-row">
        <input type="password" class="input-row" placeholder="" id="password" name="password" required>
      </div>
    </div>
    <input type="submit" value="Login">
    <div class="divider">
      <div class="line"></div>
        <span class="divider-explain">new to the site?</span>
      <div class="line"></div>
    </div>
  <a href="register.php" class="button-styled">Create an account</a>
  </form>
</body>