<?php

session_start();

include_once('../db/database.php');

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    // Utente non autenticato, potresti reindirizzarlo alla pagina di login
    header('Location: login.php');
    exit();
}

// Ottieni l'ID dell'utente dalla sessione
$loggedInUserID = $_SESSION['user_id'];

$database = new Database();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $database = new Database();

    // Image information
    $imageName = $_POST["imageName"];
    $imageData = file_get_contents($_FILES["image"]["tmp_name"]);

    echo $imageName;

    // Check if the image name already exists in the database
    if ($database->checkDuplicateImageName($imageName)) {
        echo "Error: Image name already exists in the database. Please choose a different one.";
    } else {
        // Insert the image into the database
        if ($database->uploadImage($imageName, $imageData)) {
            // Update LogoURL in the UserInfos table
            $updateLogoResult = $database->updateUserLogoURL($loggedInUserID, $imageName);

            if ($updateLogoResult) {
                echo "Image uploaded successfully. LogoURL updated.";
            } else {
                echo "Error updating LogoURL.";
            }

        } else {
            echo "Error uploading image.";
        }
    }

    header('Location: ../views/Profile.php');
}
?>
