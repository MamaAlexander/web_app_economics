<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../index.php');
    exit();
}

$game_id = $_POST['game_id'];
$count_name = $_POST['country_name'];
$_SESSION['game_id'] = $game_id;
$dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
$sql = "UPDATE game_sessions SET user2_id = :value WHERE game_id = :id";
$sth = $dbh->prepare($sql);
$id = $_SESSION['game_id'];
$value = $_SESSION['user_id'];
$sth->execute(['value' => $value, 'id' => $id]);
header("Location: index_game.php?country_name=" . $count_name);
exit();
?>