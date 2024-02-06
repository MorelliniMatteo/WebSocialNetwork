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
        if(!$database->insertSave($postID, $userID)){
            echo "Si è verificato un errore durante l'inserimento del save nel database.";
        } else {
            echo "success";
        }
    } else {
        if(!$database->removeSave($postID, $userID)){
            echo "Si è verificato un errore durante la rimozione del save dal database.";
        } else {
            echo "success";
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Dati mancanti o non validi"]);
}
?>