<?php
session_start();
require_once('../db.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../login/index.php');
    exit();
}
// Подключаемся к игре с помощью 6-значного game_id, записываем свой user_id вторыми
$game_id = $_POST['game_id'];
$count_name = $_POST['country_name'];
$_SESSION['game_id'] = $game_id;
$sql = "UPDATE game_sessions SET user2_id = :value WHERE game_id = :id";
$sth = $dbh->prepare($sql);
$id = $_SESSION['game_id'];
$value = $_SESSION['user_id'];
$sth->execute(['value' => $value, 'id' => $id]);
header("Location: index_game.php?country_name=" . $count_name);
exit();
?>