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
            echo "Image name already exists in the database.";
        } else {
            echo "Image name does not exist in the database.";
            if ($database->uploadImage($imageName, $fileData)) {
                echo "Success";
                $database->insertPost($loggedInUserID, $imageName, $description, $categoryID);
            } else {
                echo "Failed";
            }
        }
                
    } else {
        echo "Image worong";
    }

}
