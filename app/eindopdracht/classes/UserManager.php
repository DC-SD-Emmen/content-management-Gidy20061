<?php

class UserManager {

    private $conn;

    // Constructor om de databaseverbinding te initialiseren
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Methode om een game aan de wishlist van een gebruiker toe te voegen
    public function userconnect($user_id, $game_id) {
        echo "$user_id, $game_id";

        // Controleer of de game al in de wishlist staat
        foreach ($this->conn->query("SELECT * FROM user_games WHERE user_id = '$user_id' AND game_id = '$game_id'") as $row) {
            if ($row['user_id'] == $user_id && $row['game_id'] == $game_id) {
                echo "User already has this game";
                return;
            }
        }

        // Voeg de game toe aan de wishlist
        try {
            $stmt = $this->conn->prepare("INSERT INTO user_games (user_id, game_id) VALUES (?, ?)");
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $game_id);
            $stmt->execute();
            echo "New record created successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Methode om een nieuwe gebruiker toe te voegen
    public function insert($username, $password) {
        // Controleer of de gebruiker al bestaat
        if ($_POST['username'] == $username) {
            foreach ($this->conn->query("SELECT * FROM users WHERE username = '$username'") as $row) {
                if ($row['username'] == $username) {
                    echo "User already exists";
                    return;
                }
            }
        }

        // Voeg de gebruiker toe aan de database
        try {
            $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $password);
            $stmt->execute();
            echo "New record created successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Methode om een gebruiker op te halen op basis van de gebruikersnaam
    public function getUser($username) {
        try {
            // Controleer of de gebruikersnaam null is
            if ($username == null) {
                return null;
            }

            // Haal de gebruiker op uit de database
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bindParam(1, $username);
            $stmt->execute();
            //set fetchmode to associative array
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetch();
            return $user;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Methode om een game uit de wishlist van een gebruiker te verwijderen
    public function dewishlist($user_id, $game_id) {
        try {
            // Verwijder de game uit de wishlist
            $stmt = $this->conn->prepare("DELETE FROM user_games WHERE user_id = ? AND game_id = ?");
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $game_id);
            $stmt->execute();
            echo "Record deleted successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Methode om de gebruikersnaam van een gebruiker te updaten
    public function updateUsername($user_id, $username, $password) {
        try {
            // Controleer of de gebruiker bestaat
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bindParam(1, $user_id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetch();

            // Controleer of het wachtwoord overeenkomt
            if (password_verify($password, $user['password'])) {
                // Update de gebruikersnaam
                $stmt = $this->conn->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt->bindParam(1, $username);
                $stmt->bindParam(2, $user_id);
                $stmt->execute();
                $_SESSION['username'] = $username;
                echo "Record updated successfully";
            } else {
                echo "Invalid password";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Methode om de password van een gebruiker te updaten

    public function updatePassword($user_id, $current_password, $new_password) {
        try {
            // Controleer of de gebruiker bestaat
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bindParam(1, $user_id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetch();

            // Controleer of het huidige wachtwoord overeenkomt
            if (password_verify($current_password, $user['password'])) {
                // Hash het nieuwe wachtwoord
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update het wachtwoord
                $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bindParam(1, $hashed_password); // Gebruik de variabele
                $stmt->bindParam(2, $user_id);
                $stmt->execute();
                echo "Record updated successfully";
            } else {
                echo "Invalid password";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Methode om de gebruiker te verwijderen
    public function deleteAccount($user_id, $password) {
        try {
            // Controleer of de gebruiker bestaat
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bindParam(1, $user_id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetch();

            if (!$user) {
                echo "User not found";
                return;
            }

            // Controleer of het wachtwoord overeenkomt
            if (password_verify($password, $user['password'])) {
                // Verwijder de gebruiker
                $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bindParam(1, $user_id);
                $stmt->execute();
                echo "Record deleted successfully";
            } else {
                echo "Invalid password";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}