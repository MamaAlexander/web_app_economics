<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../db.php');
include_once('game_class.php');
$your_country = new Country();
$user_id = $_SESSION['user_id'];

if (isset($_POST['user_id']) && isset($_POST['game_id']) && isset($_POST['data'])) {
    $user_id = $_POST['user_id'];
    $game_id = $_POST['game_id'];
    $data = $_POST['data'];

    $query = "SELECT user1_id, user2_id FROM game_sessions WHERE game_id = ?";
    $sth = $dbh->prepare($query);
    $sth->bindParam(1, $game_id);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Игра не найдена'
        ]);
        exit;
    }
    $updateQuery = '';
    if ($result['user1_id'] == $user_id) {
        $updateQuery = "UPDATE game_sessions SET user1_ready = 1, user_id = '$user_id' WHERE game_id = ?";
    } else if ($result['user2_id'] == $user_id) {
        $updateQuery = "UPDATE game_sessions SET user2_ready = 1, user_id = '$user_id' WHERE game_id = ?";
    }

    $sth = $dbh->prepare($updateQuery);
    $sth->bindParam(1, $game_id);
    
    $your_country->modify_country_data($data, 1);

    if ($sth->execute()) {
        $query2 = "SELECT user1_ready, user2_ready FROM game_sessions WHERE game_id = ?";
        $sth2 = $dbh->prepare($query2);
        $sth2->bindParam(1, $game_id);
        $sth2->execute();
        $result2 = $sth2->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'user1_ready' => $result2['user1_ready'],
            'user2_ready' => $result2['user2_ready']
        ]);

    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Пользователь не найден в данной игре'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Не получен game_id, user_id или данные'
    ]);
}
?>
