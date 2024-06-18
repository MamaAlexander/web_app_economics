<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('game_class.php');
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../login/index.php');
    exit();
}
$your_country = new Country();
$my_country_won = $your_country->check_winner($_SESSION["count_id"], $_SESSION['op_count_id']);

// Определяем статус нашей страны: победитель/побежденный
if ($my_country_won) {
    include_once('winner_page.html');
}
else {
    include_once('loser_page.html');
}
?>
