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
    echo "Hello";
    if ($_FILES["photoInput"]["error"] === UPLOAD_ERR_OK) {
        $fileData = file_get_contents($_FILES["photoInput"]["tmp_name"]);
        $imageName = basename($_FILES["photoInput"]["name"]);
        
        if ($database->uploadImage($imageName, $fileData)) {
            echo "Success";
        } else {
            echo "Failed";
        }

        echo "FKL";
        
    } else {
        echo "Image worong";
    }

}
