<?php

    session_start();

    //if logout is pressed
    //if server method request is post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['logout'])) {
            //sessie variabelen worden leeggemaakt en verwijderd
            session_unset();
            //sessie wordt verwijderd
            session_destroy();
            header('Location: login.php');
            exit();
        }
    }

    //controleren of session username bestaat en session id
    if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
        echo "Welcome " . $_SESSION['username'];
    } else {
        header('Location: login.php');
        exit();
    }

    spl_autoload_register(function ($class_name) {
        include 'classes/' . $class_name . '.php';
    });

    $db = new Database();
    $gm = new GameManager($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Drenthe College docker web server</title>
       <link rel="stylesheet" href="./css/gamestylesheet.css">
       <link rel="stylesheet" href="./css/styles.css">
    </head>
   

<body>


    <div id="logout">
        <form method="POST">
            <input type="submit" name="logout" value="logout">
        </form>
    </div>



    <div id="hoofd">
        <h1>library</h1 >
    </div>

    <div id='main-container'>

    
        <div id= "addgame">
            <h1>Add Game</h1>
            <div id="addgame-button"> 
            <button>
                <a href="addgame.php">add game</a>
            </button>
            </div>
            <a href="wishlist.php">wishlist</a>
        </div>


        <div id="library">
        
            <?php

                $games = $gm->getAllGames();

                foreach ($games as $game) {
                    // Zorg ervoor dat de game-ID correct is opgehaald
                    echo "<div id='photo-size'>";
                    echo "<h1>" . $game->get_title() . "</h1>";
                    
                    echo '<a href="game_details.php?id=' . $game->get_id() . '">';
                    
                    // Gebruik de zelfsluitende img-tag op de juiste manier
                    echo '<img class="game-image" src="uploads/' . $game->get_foto() . '" alt="Game Image" />'; 
                    
                    echo '</a>';
                    echo '</div>';
                }
                
            ?>
        </div>

    </div>







</body>
</html>