<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="classes/gamestylesheet.css">
</head>
<body>

<?php
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

$db = new Database();
$gm = new GameManager($db);

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // Handle the file upload and store the file path
    $filePath = $gm->fileuload($_FILES['foto']);  
    // Handle the form data insertion, including the file path
    $gm->insert($_POST, $_FILES['foto']['name'] );  
}

?>
<div id="backbutton-add-game">
<h1><a href=http://localhost/index.php>
  terug  
</a> </h1>
</div>



<div id="stylesheet-addgame">
    <h1>Add-Games</h1>
   <div id="text-stylesheet-add-game">
    <form method="POST" action="" enctype="multipart/form-data">
    
    <label for='title'>title:</label>
    <input type="text" name="title" placeholder="title" required>
    <br><br>

    <label for='genre'>genre:</label>
    <input type="text" name="genre" placeholder="genre" required>
    <br><br>

    <label for='platform'>platform:</label>
    <input type="text" name="platform" placeholder="platform" required>
    <br><br>

    <label for='release_year'>release Year:</label>
    <input type="date" name="release_year" placeholder="release_year" required>
    <br><br>

    <label for='rating'>rating:</label>
    <input type="number" name="rating" placeholder="rating" required>
    <br><br>

    <label for='foto'>foto:</label>
    <input type="file" name="foto" required>
    <br><br>

    <input type="submit" name="submit" value="Submit">
</form>
</div>
</div>

</body>

</html>
