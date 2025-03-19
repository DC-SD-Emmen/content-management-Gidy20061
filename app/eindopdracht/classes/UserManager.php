<?php

    class UserManager {



        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }


        public function userconnect ($user_id, $game_id){
            echo "$user_id, $game_id";{

                foreach ($this->conn->query("SELECT * FROM user_games WHERE user_id = '$user_id' AND game_id = '$game_id'") as $row) {
                    if ($row['user_id'] == $user_id && $row['game_id'] == $game_id) {
                        echo "User already has this game";
                        return;
                    }
                }
            }

            try {
                $stmt = $this->conn->prepare("INSERT INTO user_games (user_id, game_id) VALUES (?, ?)");
                $stmt->bindParam(1, $user_id);
                $stmt->bindParam(2, $game_id);
                $stmt->execute();
                echo "New record created successfully";
                } 
                catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
            
            }
        }

        

        public function insert($username, $password) {

            if ($_POST['username'] == $username) {
                foreach ($this->conn->query("SELECT * FROM users WHERE username = '$username'") as $row) {
                    if ($row['username'] == $username) {
                        echo "User already exists";
                        return;
                    }
                }
            }

            //try and catch
            try {
                //stmt prepare
                $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bindParam(1, $username);
                $stmt->bindParam(2, $password);
                $stmt->execute();
                echo "New record created successfully";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

        }

        public function getUser($username) {

            //try and catch
            try {
                //stmt prepare
                //if no user is found, return user is null (in associative array)
                if($username == null) {
                    return null;
                }
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->bindParam(1, $username);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
            }
            catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
        }

        public function dewishlist($user_id, $game_id) {
            try {
                $stmt = $this->conn->prepare("DELETE FROM user_games WHERE user_id = ? AND game_id = ?");
                $stmt->bindParam(1, $user_id);
                $stmt->bindParam(2, $game_id);
                $stmt->execute();
                echo "Record deleted successfully";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
}

