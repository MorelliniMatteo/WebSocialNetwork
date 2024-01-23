<?php
session_start();
define("UPLOAD_DIR", "img/");
require_once("utils/functions.php");
require_once("db/database.php");
$db = new Database();
?>