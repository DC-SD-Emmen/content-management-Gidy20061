<?php

    //spl autoload classes uit de classes map
    spl_autoload_register(function ($class_name) {
        include 'classes/' . $class_name . '.php';
    });

    //session start
    session_start();

    //controleren of er is ingelogd
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id']; // Haal het gebruikers-ID uit de sessie
    } else {
        // Als de gebruiker niet is ingelogd, stuur door naar de loginpagina
        $user_id = null;
        header('Location: login.php');
        exit();
    }

    //new database object
    $db = new Database();
    //new usermanager object
    $userM = new UserManager($db->getConnection());

    // Haal de gebruiker op
    $user = $userM->getUser($_SESSION['username']);

    // Controleer of de gebruiker is gevonden
    if ($user) {
    } else {
        // Als de gebruiker niet is gevonden, toon een foutmelding en beëindig het script
        echo "Error: User not found.";
        exit();
    }

    //if server method request is POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //if update is pressed
        if (isset($_POST['update'])) {
            //update username
            $userM->updateUsername($user_id, $_POST['username'], $_POST['password']);
        }
        //if update password is pressed
        if (isset($_POST['update_password'])) {
            //update password
            $userM->updatePassword($user_id, $_POST['current_password'], $_POST['new_password']);
        }
        //if delete is pressed
        if (isset($_POST['delete'])) {
            //delete account
            $userM->deleteAccount($user_id, $_POST['password']);
        }
    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/gamestylesheet.css">
</head>
<body>

    <div id="backbutton-add-game">
        <h1><a href='./index.php'>
            terug  
         </a> </h1>
    </div>


    <!-- fomulier voor updaten van username met password controle -->
    <form method="POST" class='basic-form'>
        <label for="username">username</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>"><br>
        <label for="password">password</label>
        <input type="password" name="password" placeholder="password"><br>
        <input type="submit" name="update" value="update">
        <br>
    </form>

    <!-- formulier voor updaten van password met huidig password controle-->
    <form method="POST" class='basic-form'>
        <label for="current_password">current password</label>
        <input type="password" name="current_password" placeholder="current password"><br>
        <label for="new_password">new password</label>
        <input type="password" name="new_password" placeholder="new password"><br>
        <input type="submit" name="update_password" value="update password">
        <br>
    </form>

    <!-- formulier voor verwijderen van account met password controle -->
    <form method="POST" class='basic-form'>
        <label for="password">password</label>
        <input type="password" name="password" placeholder="password"><br>
        <input type="submit" name="delete" value="delete account">
        <br>
    </form>


    
</body>
</html>