<?php


    class UserManager {

        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function insert($username, $password) {

            //wat je hier ook nog kan doen, is checken of de user al bestaat of niet.

            //if user al bestaat? geen nieuwe aanmaken
            if ($_POST['username'] == $username) {
                foreach ($this->conn->query("SELECT * FROM users WHERE username = '$username'") as $row) {
                    if ($row['username'] == $username) {
                        echo "User already exists";
                        return;
                    }
                }
            }

            //else wel nieuwe user maken.
            else {
                echo "New user created";
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

//        public function getUser($id)
//        {
//
//        }
}