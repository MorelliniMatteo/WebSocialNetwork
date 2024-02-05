<?php
include_once('../db/database.php');

// Assume the user is logged in and you have the user ID
$loggedInUserID = 4; //Replace with the actual logged-in user ID

$database = new Database();

$userData = $database->getUserByID($loggedInUserID);

function generatePostHTML($post) {
    $postSerialized = urlencode(json_encode($post));

    $html = '<div class="post-img">';
    $html .= '<form action="post.php" method="post">';
    $html .= '<input type="hidden" name="post" value="' . $postSerialized . '">';
    $html .= '<button type="submit" name="viewPost" label="View Full Post"><img src="' . $post['MediaURL'] . '" alt="Post Image"></button>';
    $html .= '</form>';
    $html .= '</div>';

    return $html;
}


if (isset($_POST['dati'])) {
    $post = json_decode($_POST['dati'], true);
    echo generatePostHTML($post, $database, $userData);
}


?>