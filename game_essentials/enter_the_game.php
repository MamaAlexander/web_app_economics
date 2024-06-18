<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if ($_SESSION['user_id'] == '') {
  $_SESSION['message'] = 'You need to authorise first';
  header('Location: ../login/index.php');
  exit();
}
require_once('../db.php');
$sth = $dbh->prepare("SELECT * FROM web_session WHERE cookie_id = :cookie_id and user_id = :user_id");
$session_id = $_SESSION['session_id'];
$user_id = $_SESSION['user_id'];
$sth->execute(array('cookie_id' => $session_id, 'user_id' => $user_id));
$array = $sth->fetch(PDO::FETCH_ASSOC);
// Проверяем играет ли уже пользователь в этой сессии, вдруг он случайно вышел из игры
if ($array['country_id'] == 0) {
    include_once('game_enter.html');
} else {
    include_once('buttons.html');
}
?>
