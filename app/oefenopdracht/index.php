<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styling.css">
</head>
<body>

<div id="container">
    <form method="POST" action="oefenopdracht1-login.php"> <!-- Correct action URL -->
    <div id="user">
      <div class="username">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username" required>
      </div>

      <div class="password">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>
      </div>

      <input id="styling-log-in" type="submit" value="Log in">
    </div>
  </form>
</div>
</body>
</html>