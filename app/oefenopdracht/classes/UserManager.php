<?php


    class UserManager
    {

        private $conn;

        public function __construct($conn)
        {
            $this->conn = $conn;
        }

        public function insert($username, $password)
        {

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

        public function getUser($username)
        {

            //try and catch
            try {
                //stmt prepare
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->bindParam(1, $username);
                $stmt->execute();
                return $stmt->fetch();
            }
            catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }


        }

}