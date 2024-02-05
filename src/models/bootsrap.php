<?php

    session_start();

    include_once('../db/database.php');

    if (!isset($_SESSION['user_id'])) {
        // Utente non autenticato,  viene reinderizzato alla pagina di login
        header('Location: login.php');
        exit();
    }

    // Ottieni l'ID dell'utente dalla sessione
    $userID = $_SESSION['user_id'];
?>