<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// проверка того, что пользователь вошел в аккаунт
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../login/index.php');
    exit();
}
include_once('profile.html');
?>
