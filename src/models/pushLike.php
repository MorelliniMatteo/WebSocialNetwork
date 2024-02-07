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
if (isset($_POST['postID']) && isset($_POST['userID']) && isset($_POST['add'])) {
    $postID = $_POST['postID'];
    $userID = $loggedInUserID;
    $add = $_POST['add'];
    echo $add;
    
    if($add){
        if(!$database->insertLike($postID, $userID)){
            echo "Si è verificato un errore durante l'inserimetno nel database.";
        } else {
            $toUserID = $database->getUserIDByPostID($postID);
            $database->insertNotification($userID, $toUserID, "like", $postID);
            echo "Insert success";
        }
    } else {
        if(!$database->removeLike($postID, $userID)){
            echo "Si è verificato un errore durante la rimozione del like dal database.";
        } else {
            echo "Remove success";
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Dati mancanti o non validi"]);
}
?>