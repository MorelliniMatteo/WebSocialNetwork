<?php 

session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$loggedInUserID = $_SESSION['user_id'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Select Image:</label>
        <input type="file" name="image" id="image">
        <label for="imageName">Image Name:</label>
        <input type="text" name="imageName" id="imageName">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</body>
</html>
