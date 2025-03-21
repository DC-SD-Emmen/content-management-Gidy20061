<?php

// Start de sessie om gebruikersinformatie te behouden
session_start();

// Controleer of de gebruiker is ingelogd
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id']; // Haal het gebruikers-ID uit de sessie
} else {
    // Als de gebruiker niet is ingelogd, stuur door naar de loginpagina
    $user_id = null;
    header('Location: login.php');
    exit();
}

// Autoload functionaliteit voor het automatisch laden van klassen
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

// Maak een nieuwe databaseverbinding
$db = new Database();

// Initialiseer de GameManager en UserManager met de databaseverbinding
$gm = new GameManager($db);
$userM = new UserManager($db->getConnection());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/gamestylesheet.css"> <!-- Verwijzing naar de stylesheet -->
    <title>Document</title>
</head>
<body>

<div id= "title">
    <h1>Wishlist</h1>
</div>

<div id="backbutton-add-game">
    <h1><a href='./index.php'>
    terug  
    </a> </h1>
</div>

<div id='main-container'> <!-- Hoofdcontainer voor de inhoud -->
   
   
    <div id="library"> <!-- Sectie voor de gamebibliotheek -->
        
        <?php
            // Haal de wishlist van de gebruiker op
            $games = $gm->getWishlist($user_id);

            // Loop door de lijst met games en toon ze
            foreach ($games as $game) {
                echo "<div id='photo-size'>"; // Container voor elke game
                echo "<h1>" . $game->get_title() . "</h1>"; // Toon de titel van de game
                echo '<a href="game_details.php?id=' . $game->get_id() . '">'; // Link naar de game details
                echo '<img class="game-image" src="uploads/' . $game->get_foto() . '" alt="Game Image" />'; // Toon de afbeelding van de game
                echo '</a>';
                echo '</div>';
            }
        ?>
    </div>
</div>



</body>
</html>