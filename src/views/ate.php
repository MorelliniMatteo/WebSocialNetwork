<?php

include_once("../models/ImageHelper.php");

$database = new Database();

echo getImageSourceLink($database, "profile.jpg");