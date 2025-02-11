<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Drenthe College docker web server</title>
       <link rel="stylesheet" href="classes/gamestylesheet.css">
    </head>
   

<body>



    <?php

        spl_autoload_register(function ($class_name) {
            include 'classes/' . $class_name . '.php';
        });

        $db = new Database();
        $gm = new GameManager($db);
    ?>



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