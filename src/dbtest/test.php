<?php

include_once('../db/database.php');

$database = new Database();

$users = $database->getUsers();
$categories = $database->getCategories();
$posts = $database->getPosts();
$followers = $database->getFollowers();
$comments = $database->getComments();
$chatMessages = $database->getChatMessages();
$notifications = $database->getNotifications();


?>