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
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/UpdateProfile.css">
</head>
<body>

    <div class="form-container">
        <form action="UploadImage.php" method="post" enctype="multipart/form-data">
            <section>
                <label for="ChangeIcon" class="specialLabel">Change Your Icon</label>
                <button type="button" class="back-button" id="backButton" onclick="goBack()">Back</button>
            </section>
            
            <label for="image" id="imageLabel" class="custom-button">Select Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>
            <label for="imageName">Image Name:</label>
            <input type="text" name="imageName" id="imageName" placeholder="Type your image name..." required>
            <input type="submit" value="Upload Image" name="submit" id="submitButton">
        </form>
    </div>

    <script src="../js/updateProfileImage.js"></script>
    <script src="../js/importTheme.js"></script>
    <script src="../js/backbutton.js"></script>
</body>
</html>
