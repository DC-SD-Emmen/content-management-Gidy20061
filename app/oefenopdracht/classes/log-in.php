<?php


// Autoloader function for loading classes automatically
spl_autoload_register(function ($class_name) {
    require_once 'classes/' . $class_name . '.php';
});

$db = new Database();
// Assuming UserManager accepts the DB connection
$userM = new UserManager($db->getConnection());

$userI = ($db->getConnection());

//if server method request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//if isset login
    if (isset($_POST['log-in'])) {

//je kan hier nog regex controle toevoegen
        $username = htmlspecialchars($_POST['username']);

        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $userM->insert($username, $password);
    }
//    if (password_verify($password, $userI('password')))
//        echo "login succes";
//
//        header('Location: index.php');
//    else
//        echo "login failed";

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

    <form method="POST" id="loginForm">

<!--        <label for="username">Username: </label>-->
        <input type="text" name="username" id="username">
        <br>
<!--        <label for="password">Password: </label>-->
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="login" id="log-in" name="login">

    </form>
</div>



</body>


</html>

