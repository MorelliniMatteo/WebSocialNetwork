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

function uploadImage($database, $path, $imageName) {
    $imageData = file_get_contents($path . $imageName);
    if($database->uploadImage($imageName, $imageData)) {
        echo "Image uploaded successfully!";
    } else {
        echo "Failed to upload Image!";
    }
    
}


// Example
// echo getImageSourceLink($database, "profile.jpg");

// echo uploadImage($database, '../img/', 'backgndSculpture.jpg');