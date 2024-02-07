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

include_once('../db/database.php');

$database = new Database();

// Verifica se sono stati ricevuti i dati corretti tramite POST
if (isset($_POST['index']) && isset($_POST['queryName']) && isset($_POST['categoryID'])){
    $index = $_POST['index'];
    $queryName = $_POST['queryName'];
    $categoryID = $_POST['categoryID'];

    if ($queryName == 'explore') {
        if ($categoryID) {
            $categoryID = $_POST['categoryID'];
            $posts = $database->getPostsByCategory($categoryID, $index);
            $_SESSION['categoryID'] = null ;
        } else {
            $posts = $database->getRandomPosts($index);
        }
    } else {
        $posts = $database->getPostFromFollowing($loggedInUserID, $index);
    }

    if ($posts) {
        echo json_encode(["posts" => $posts]);
    } else {
        echo json_encode(["status" => "error", "message" => "Si è verificato un errore durante il caricamento dei post dal database."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Dati mancanti o non validi"]);
}

?>