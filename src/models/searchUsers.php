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

// Gestione dell'invio del form search
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $searchQuery = $_POST["Search"];
    if ($searchQuery) { 
        $usersFound = $database->getUsersByString($searchQuery);
        $_SESSION["usersFound"] = $usersFound;
    } else {
        echo 'No users found.';
    }

    // Ridirigi alla stessa pagina
    header("Location: ../views/home.php");
    exit();
}
?>
