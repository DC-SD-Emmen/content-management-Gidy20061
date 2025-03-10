<?php
session_start();

use Couchbase\User;

// Autoloader function for loading classes automatically
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

$db = new Database();
// Assuming UserManager accepts the DB connection
$userM = new UserManager($db->getConnection());

//if server method request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//if isset login
    if (isset($_POST['register'])) {
//je kan hier nog regex controle toevoegen
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $userM->insert($username, $password);
    }

    $Server = $_SERVER['REQUEST_METHOD'];
    echo $Server;
    
    if (isset($_POST['login'])) {

        //username en password uit POST data
        $username = $_POST['username'];
        $password = $_POST['password'];

        //user uit Usermanager ophalen
        $user = $userM->getUser($username);

        //password verify
        if(password_verify($password, $user['password'])) {
            echo "login succes";
        } else {
            echo "login failed";
        }


    }



}


?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styling.css">
    <script src="sign-in.php"></script>
</head>

<body>

<div id="form-container">
    <form method="POST" id="registerForm">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="register" id="Register-button" name="register">
    </form>
</div>

<div id="form-container">
    <form method="POST" id="loginForm">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="Login" id="login-button" name="login">
    </form>
</div>



</body>


</html>