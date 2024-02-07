<?php
include_once('../db/database.php');

$database = new Database();

// Verifica se sono stati ricevuti i dati corretti tramite POST
if (isset($_POST['postID']) && isset($_POST['userID']) && isset($_POST['add'])) {
    $postID = $_POST['postID'];
    $userID = $_POST['userID'];
    $add = $_POST['add'];
    echo $add;
    
    if($add){
        if(!$database->insertLike($postID, $userID)){
            echo "Si è verificato un errore durante l'inserimetno nel database.";
        } else {
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