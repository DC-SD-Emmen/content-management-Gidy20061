<?php

session_start();

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    // Handle the case where the session ID is not set
    $user_id = null;
    header('Location: login.php');
    exit();
}

spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

$db = new Database();
$gm = new GameManager($db);
$userM = new UserManager($db->getConnection());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/gamestylesheet.css">
    <title>Document</title>
</head>
<body>

<div id='main-container'>
    <div id="library">
        <?php
            $games = $gm->getWishlist($user_id);

            foreach ($games as $game) {
                echo "<div id='photo-size'>";
                echo "<h1>" . $game->get_title() . "</h1>";
                echo '<a href="game_details.php?id=' . $game->get_id() . '">';
                echo '<img class="game-image" src="uploads/' . $game->get_foto() . '" alt="Game Image" />';
                echo '</a>';
                echo '</div>';
            }
        ?>
    </div>
</div>

</body>
</html>