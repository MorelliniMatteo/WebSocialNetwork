<?php
session_start();

// 销毁所有会话变量
$_SESSION = array();


if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// 最终销毁会话
session_destroy();

header('Location: login.php');
exit();
?>
