<?php

$servername = "mysql";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Autoloader function for loading classes automatically
spl_autoload_register(function ($class) {
    require_once __DIR__ . '/classes/' . $class . '.php';
});

// Assuming UserManager accepts the DB connection
$us = new UserManager($conn);

// Create a new User object
$users = new User();
$users->setUsername("admin");
$users->setPassword(password_hash("<PASSWORD>", PASSWORD_DEFAULT)); // Hashing password for security
$users->setRoles(["admin"]);

// Insert user into the database (make sure insert() is implemented in UserManager)
$us->insert($users); // Pass the $users object for insertion
echo "User inserted";

// Retrieve and display the password (hashed for security)
$password = $users->getPassword();
echo "Password (hashed): " . $password;

// MySQL query to fetch users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["username"]. " - Roles: " . $row["roles"]. "<br>";
    }
} else {
    echo "0 results";
}
?>