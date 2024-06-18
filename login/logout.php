<?php
session_start();
setcookie("user_id", "", time() - 3600, "/");
$_SESSION['user_id'] = '';
session_unset();
session_destroy();
header('location:index.php');
?>