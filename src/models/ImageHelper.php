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


?>