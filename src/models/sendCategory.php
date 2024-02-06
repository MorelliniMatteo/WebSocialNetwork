<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

//default categoryID to display all post
$categoryID = 0;

// Gestione dell'invio del form search
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $searchQuery = $_POST["Search"];
    if ($searchQuery) { 
        $categoryID = $database->getCategoryID($searchQuery);
        $_SESSION["categoryID"] = $categoryID;
    } else {
        echo 'default category: all';
    }

    // Ridirigi alla stessa pagina
    header("Location: ../views/explore.php");
    exit();
}
?>
