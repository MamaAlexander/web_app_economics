<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
require_once('../db.php');

if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../login/index.php');
    exit();
}
// Создаем новую игровую сессию, добавляя информацию об игроке в игровую сессию,
// и генерируем 6-значный ключ для подключения второго игрока, если ключ уже есть в таблице, то удаляем его
$count_name = $_POST['country_name'];
$_SESSION['count_name'] = $count_name;
$user_id = $_SESSION["user_id"];
$game_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
$_SESSION['game_id'] = $game_id;
$query2 = "SELECT COUNT(*) FROM game_sessions WHERE game_id = :game_id";
$sth = $dbh->prepare($query2);
$sth->execute(array('game_id' => $game_id));
$count = $sth->fetchColumn();
if ($count == 1) {
    $query3 = "DELETE FROM game_sessions WHERE game_id = :game_id";
    $sth = $dbh->prepare($query3);
    $sth->execute(array('game_id' => $game_id));
}

$query = "INSERT INTO game_sessions (game_id, user1_id, user1_ready, user2_ready, step) VALUES (:game_id, :user_id, 0, 0, 1)";
$sth = $dbh->prepare($query);
$sth->execute(array('game_id' => $game_id, 'user_id' => $user_id));

header("Location: index_game.php?country_name=" . $count_name);
exit();
?>