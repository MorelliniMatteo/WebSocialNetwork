<?php
include_once('../db/database.php');

$database = new Database();

$loggedInUserID = 4; //Replace with the actual logged-in user ID

// Verifica se sono stati ricevuti i dati corretti tramite POST
if (isset($_POST['index']) && isset($_POST['queryName'])){
    $index = $_POST['index'];
    $queryName = $_POST['queryName'];

    if ($queryName == 'explore') {
        if (isset($_POST['categoryID'])) {
            $categoryID = $_POST['categoryID'];
            $posts = $database->getPostsByCategory($categoryID, $index);
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