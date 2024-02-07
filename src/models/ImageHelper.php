<?php

include_once('../db/database.php');


function getImageSourceLink($database, $imageName) {
    $imageBase64 = $database->getImageAsBase64($imageName);
    if ($imageBase64) {
        return 'data:image/jpg;base64,' . $imageBase64;
    } else {
        return 'Not found';
    }
}


function displayProfileImage($database, $logoURL) {
    $imageLink = getImageSourceLink($database, $logoURL);

    if ($imageLink === "Not found") {

        return "../img/defaultUserPng.jpg"; 
    } else {

        return $imageLink;
    }
}

