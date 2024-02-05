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

include_once("../db/database.php");

$database = new Database();

// Placeholder for error message
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmButton'])) {

    $category = $_POST['category'];
    $description = $_POST['descriptionInput'];
    $categoryID = $database->getCategoryID($category);

    if ($_FILES["photoInput"]["error"] === UPLOAD_ERR_OK) {
        $fileData = file_get_contents($_FILES["photoInput"]["tmp_name"]);
        $imageName = basename($_FILES["photoInput"]["name"]);

        if ($database->imageNameExists($imageName)) {
            $errorMessage = "Image name already exists in the database.";
        } else {
            if ($database->uploadImage($imageName, $fileData)) {
                $database->insertPost($loggedInUserID, $imageName, $description, $categoryID);
            } else {
                $errorMessage = "Insert Post Failed";
            }
        }
    } else {
        $errorMessage = "Upload Image Failed";
    }

}
?>
