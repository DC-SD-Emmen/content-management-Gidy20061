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

?>
<div id="backbutton-add-game2">
 <h1><a href=http://localhost/index.php>
  terug  
 </a> </h1>
</div>

<div id="hoofd2">
    <h1>library</h1 >
</div>

<div id="main-container"> 


<div id="GameLibrary">
    
<?php

spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

$db = new Database();
$gm = new GameManager($db);

// Haal de game ID op uit de URL parameter
if (isset($_GET['id'])) {

    $game_id = $_GET['id'];


    // Sanitize de input om SQL injectie te voorkomen
    $game_id = htmlspecialchars($game_id);

    $result = $gm->getSingleGame($game_id);


    foreach($result as $game) {

        echo "<div id='game-foto'>
        <img class='game-image' src='uploads/" . $game->get_foto() . "'>
        </div>";

        echo "<div id='game-Info'>
        <h1> title: " . $game->get_title() . "</h1>
        <h1> genre: " . $game->get_genre() . "</h1>
        <h1> platform: " . $game->get_platform() . "</h1>
        <h1> release year: " . $game->get_release_year() . "</h1>
        <h1> rating: " . $game->get_rating() . "/10</h1>
        </div>";
    
    }
}




?>

   
   </div>
</div>
</div>







</body>
</html>





