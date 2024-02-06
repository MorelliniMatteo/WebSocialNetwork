<?php
session_start();

// Ottieni il valore della variabile categoryID
$categoryID = isset($_SESSION["categoryID"]) ? $_SESSION["categoryID"] : 0;

// Restituisci il valore come JSON
echo json_encode(['categoryID' => $categoryID]);
?>