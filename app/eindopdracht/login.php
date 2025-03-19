<?php

    session_start();

    // Autoloader function for loading classes automatically
    spl_autoload_register(function ($class_name) {
        require_once 'classes/' . $class_name . '.php';
    });

    $db = new Database();
    // Assuming UserManager accepts the DB connection
    $userM = new UserManager($db->getConnection());


    //if server method request is POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //if isset login
        if (isset($_POST['login'])) {

            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];

            //regex for username
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                echo "Invalid username";
                exit();
            }
    
            //user uit Usermanager ophalen
            $user = $userM->getUser($username);

            //if user is null abort
            if ($user == null) {
                echo "login failed";
            } else {
                    //password verify
                if(password_verify($password, $user['password'])) {

                    //hier worden sessie variabelen geset (aangemaakt)
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $user['id'];

                    header('Location: index.php');
                    exit();
                
                } else {
                    echo "login failed";
                }
            }
    
            
            
        }

    }


?>


<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/gamestylesheet.css">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="sign-in.php"></script>
</head>

<body>

<div id="form-container">

    <form method="POST" id="loginForm">

<!--        <label for="username">Username: </label>-->
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">
        <br>
<!--        <label for="password">Password: </label>-->
        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="login" id="log-in" name="login">

    </form>
</div>
<div id="inloggen">

    <div id="regrister-butten">
        <form method="GET" action="register.php">
            <input type="submit" value="register" id="Register-button" name="register">
        </form>
    </div>

</div>


</body>


</html>

