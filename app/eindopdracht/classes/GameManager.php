<?php

class GameManager {
    private $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getConnection();
    }

    // Voeg formuliergegevens in de database in
    public function insert($data, $fileName)
    {
        //htmlspecialchars tegen Script injectie
        $title = htmlspecialchars($data['title']);
        $genre = htmlspecialchars($data['genre']);
        $platform = htmlspecialchars($data['platform']);
        $release_year = htmlspecialchars($data['release_year']);
        $rating = htmlspecialchars($data['rating']);

        $sql = "INSERT INTO games (title, genre, platform, release_year, rating, foto) 
                VALUES (:title, :genre, :platform, :release_year, :rating, :foto)";

        try {
            $stmt = $this->conn->prepare($sql);
            //het binden van data, doen we om SQL injectie te voorkomen
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':platform', $platform);
            $stmt->bindParam(':release_year', $release_year);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':foto', $fileName);  // Store file path
            $stmt->execute();
            echo "New record created successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    // Behandelaar voor het uploaden van bestanden
    public function fileuload($file)
    {
        // Controleer of het bestand is geüpload
        if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($file["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Controleert of het afbeeldingsbestand een geldige afbeelding is
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            //Controleer of het bestand al bestaat
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Controleer de bestandsgrootte (limiet tot 500 KB)
            if ($file["size"] > 5000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            //Sta bepaalde bestandsformaten toe
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Als de controles op het uploaden van bestanden slagen, verplaatst die het geüploade bestand naar de doelmap
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                return null;  // Retourneer null als het uploaden is mislukt
            } else {
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
                    return $target_file;  // Retourneer het bestandspad dat u in de database wilt opslaan
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    return null;  // Retourneer null als er een fout is opgetreden bij het uploaden
                }
            }
        } else {
            return null;  // Als er geen bestand is geüpload of als er een fout is opgetreden
        }
    }


    public function getWishlist($user_id){
         // Initialiseer een lege array om de spelobjecten op te slaan
         $games = [];

         // Bereid de SQL-query voor om alle games op te halen
         //SELECT * FROM user_games = selecteer alles van de tabel 'user_id'
        $sql = "SELECT games.*
        FROM games
        INNER JOIN user_games ON games.id = user_games.game_id
        WHERE user_games.user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);

         // Voer de query uit met PDO
            $stmt->execute();
 
         // Controleer of er resultaten zijn
         if ($stmt) {
             // Haalt alle resultaten op als associatieve arrays
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
             //Doorloop elk resultaat en maak een nieuw Game-object
             foreach ($result as $row) {
                 // Ervan uitgaande dat de game class constructor rijgegevens gebruikt
                 $game = new Game($row);
 
                 // Voeg het Game-object toe aan de games-array
                 $games[] = $game;
             }
         }
 
         // Retourneer de reeks spel objecten
         return $games;
    }

    public function getAllGames()
    {
        // Initialiseer een lege array om de spelobjecten op te slaan
        $games = [];

        // Bereid de SQL-query voor om alle games op te halen
        //SELECT * FROM games = selecteer alles van de tabel 'games'
        $sql = "SELECT * FROM games";

        // Voer de query uit met PDO
        $stmt = $this->conn->query($sql);

        // Controleer of er resultaten zijn
        if ($stmt) {
            // Haalt alle resultaten op als associatieve arrays
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Doorloop elk resultaat en maak een nieuw Game-object
            foreach ($result as $row) {
                // Ervan uitgaande dat de game class constructor rijgegevens gebruikt
                $game = new Game($row);

                // Voeg het Game-object toe aan de games-array
                $games[] = $game;
            }
        }

        // Retourneer de reeks spel objecten
        return $games;
    }

    public function getSingleGame($id)
    {
        //deze functie is bijna helemaal hetzelfde als getAllGames
        //maar gaat maar 1 game ophalen, aan de hand van de ID die je meegeeft.
        //en dan return die informatie over die ene game op dezelfde manier als bij getAllGames
        $games = [];


        // Haal de details van de specifieke game op
        $sql = "SELECT * FROM games WHERE id = '$id'";
        $result = $this->conn->query($sql);

        // Voert de query uit met PDO
        $stmt = $this->conn->query($sql);

        // Check of er resultaat is
        if ($stmt) {
            // Retourneer de reeks spel objecten
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Doorloop elk resultaat en maak een nieuw Game-object
            foreach ($result as $row) {
                // Ervan uitgaande dat de game class constructor row info gebruikt
                $game = new Game($row);

                // Voeg het Game-object toe aan de games-array
                $games[] = $game;
            }
        }

        // Retourneer de reeks spel objecten
        return $games;
    }
}


?>
