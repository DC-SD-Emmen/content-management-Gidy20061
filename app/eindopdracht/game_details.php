<?php
    // Start de sessie
    session_start();

    // Autoload classes uit de 'classes' map
    spl_autoload_register(function ($class_name) {
        include 'classes/' . $class_name . '.php';
    });
?>
<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Drenthe College docker web server</title>
       <!-- Stylesheets voor de pagina -->
       <link rel="stylesheet" href="./css/gamestylesheet.css">
       <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<!-- Formulier voor wishlist functionaliteit -->
<div id="add-to-wishlist">
    <form method="POST">
        <!-- Verberg het game ID in een hidden input -->
        <input type="hidden" name="game_id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
        <!-- Knoppen om toe te voegen of te verwijderen uit de wishlist -->
        <input type="submit" name="add-to-wishlist" value="add to wishlist">
        <input type="submit" name="delete-from-wishlist" value="delete from wishlist">
        <?php
        // Toon wishlist link als de gebruiker is ingelogd
        if (isset($_SESSION['id'])) {
            echo "<a href='wishlist.php'>wishlist</a>";
        }
        ?>
    </form>
</div>

<!-- Terugknop naar de indexpagina -->
<div id="backbutton-add-game2">
 <h1><a href='./index.php'>terug</a></h1>
</div>

<!-- Titel van de bibliotheek -->
<div id="hoofd2">
    <h1>library</h1>
</div>

<!-- Game bibliotheek sectie -->
<div id="GameLibrary">
    <?php
    // Maak database- en manager-objecten aan
    $db = new Database();
    $gm = new GameManager($db);
    $userM = new UserManager($db->getConnection());

    // Controleer of de gebruiker is ingelogd
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
    } else {
        $user_id = null; // Geen gebruiker ingelogd
    }

    // Haal het game ID op uit de URL
    if (isset($_GET['id'])) {
        $game_id = $_GET['id'];
    } else {
        $game_id = null; // Geen game ID opgegeven
    }

    // Verwerk formulierinvoer
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Voeg toe aan wishlist
        if (isset($_POST['add-to-wishlist'])) {
            if (isset($_SESSION['id']) && isset($_POST['game_id'])) {
                $user_id = $_SESSION['id'];
                $game_id = $_POST['game_id'];
                $userM->userconnect($user_id, $game_id);
            } else {
                echo "something went wrong";
            }
        }
        // Verwijder uit wishlist
        if (isset($_POST['delete-from-wishlist'])) {
            $user_id = $_SESSION['id'];
            $game_id = $_POST['game_id'];
            $userM->dewishlist($user_id, $game_id);
        }
    }

    // Haal game details op als er een game ID is
    if ($game_id !== null) {
        // Sanitize de input om SQL injectie te voorkomen
        $game_id = htmlspecialchars($game_id);
        $result = $gm->getSingleGame($game_id);

        // Toon game details
        foreach ($result as $game) {
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

</body>
</html>