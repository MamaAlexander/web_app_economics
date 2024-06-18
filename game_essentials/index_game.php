<?php
session_start();
include_once('game_class.php');
require_once('../db.php');
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../login/index.php');
    exit();
}
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$user_id = $_SESSION["user_id"];
$game_id = $_SESSION['game_id'];
$message = '';
$error = '';
$your_country = new Country();
$op_country = new Country();

$sth = $dbh->prepare("SELECT * FROM web_session WHERE cookie_id = :cookie_id and user_id = :user_id");
$session_id = $_SESSION['session_id'];

$sth->execute(array('cookie_id' => $session_id, 'user_id' => $user_id));
$array = $sth->fetch(PDO::FETCH_ASSOC);


if ($array['country_id'] == 0) {
  $your_country->set_new_country($_GET['country_name']);
}

$sth = $dbh->prepare("SELECT * FROM game_sessions WHERE game_id = :game_id");
$sth->execute(array('game_id' => $game_id));
$array2 = $sth->fetch(PDO::FETCH_ASSOC);

// Записываем ID своей страны в зависимости от того, создали ли мы игру или просто подключились 
if ($array2['country1_id'] == 0 && $array2['country2_id'] == 0) {
  $country = $your_country->get_country_data($_SESSION["count_id"]);
  $query = "UPDATE game_sessions SET country1_id = :value WHERE game_id = :id";
  $sth = $dbh->prepare($query);
  $sth->execute(array('value' => $country['country_id'], 'id' => $game_id));
  // $your_country->modify_country_data();
} else if ($array2['country1_id'] != $_SESSION['count_id'] and $array2['country2_id'] == 0) {
  $country = $your_country->get_country_data($_SESSION["count_id"]);
  $query = "UPDATE game_sessions SET country2_id = :value WHERE game_id = :id";
  $sth = $dbh->prepare($query);
  $sth->execute(array('value' => $country['country_id'], 'id' => $game_id));
  // $your_country->modify_country_data();
} else {
  $country = $your_country->get_country_data($_SESSION["count_id"]);
}

// Определяем ID страны противника
if ($country['country_id'] == $array2['country1_id']) {
  $opponent_country_id = $array2['country2_id'];
  $country_id = $array2['country1_id'];
} else {
  $opponent_country_id = $array2['country1_id'];
  $country_id = $array2['country2_id'];
}
$_SESSION['op_count_id'] = $opponent_country_id;

// Переходим к странице итогов
if ($country['num_of_steps'] == 0) {
  $_SESSION['game_ended'] == 1;
  header('Location: endgame_page.php');
  exit;
}

// Подгружаем информацию о противнике вручную
if ($array2['country2_id'] != 0 and $array2['country1_id'] != 0) {
  $sth = $dbh->prepare("SELECT * FROM country_data WHERE `country_id` = :id");
  $sth->execute(array('id' => $opponent_country_id));
  $array6 = $sth->fetch(PDO::FETCH_ASSOC);
  $opponent_country = $array6;
}
// Подгружаем поля и начинаем игру
$your_country->set_fields($country_id);
include_once('index_game.html');
?>

