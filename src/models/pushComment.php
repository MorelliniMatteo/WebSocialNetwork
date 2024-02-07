<?php
include_once('../db/database.php');

$database = new Database();

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $PostID = $_POST["PostID"];
        $UserID = $_POST["UserID"];
        $CommentText = $_POST["CommentText"];

        //control over the text inserted in comments
        if ( $CommentText == '') {
            exit();
        }

        if (!$database->insertComment($PostID, $UserID, $CommentText)) {
            echo "Si è verificato un errore durante l'inserimento del commento.";
        }

    } catch (PDOException $e) {
        echo "Errore di connessione al database: " . $e->getMessage();
    }
}

?>