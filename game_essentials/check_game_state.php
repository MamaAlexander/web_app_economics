<?php
    session_start();
    require_once('../db.php');
    $game_id = $_SESSION['game_id'];
    $user_id = $_SESSION['user_id'];

    //файл проверки статусов игроков, которые меняются в update_player_state.php
    $query = "SELECT user1_ready, user2_ready, update_game, user_id FROM game_sessions WHERE game_id = ?";
    $statement = $dbh->prepare($query);
    $statement->bindParam(1, $game_id, PDO::PARAM_STR);
    $statement->execute();
    $game_state = $statement->fetch(PDO::FETCH_ASSOC);

    // если выполнены эти условия, то мы должны перейти к новому раунду и поменять все значения обратно на нули  
    if ($game_state['user1_ready'] == 0 && $game_state['user2_ready'] == 0 && $game_state['update_game'] == 1) {
        $query2 = "UPDATE game_sessions SET user1_ready = 0, user2_ready = 0, update_game = 0, user_id = '0' WHERE game_id = ?";
        $statement = $dbh->prepare($query2);
        $statement->bindParam(1, $game_id, PDO::PARAM_STR);
        $statement->execute();
    }
    
    // если выполнены эти условия, то мы должны поменять значение update_game на 1, чтобы второй игрок смог тоже заслать свои изменения
    // если бы не было update_game, то после того как первый успевший игрок завершит ход, 
    // мы сразу перейдем к следующему ходу, даже если второй не успел походить
    if ($game_state['user1_ready'] == 1 && $game_state['user2_ready'] == 1) {
        $query2 = "UPDATE game_sessions SET user1_ready = 0, user2_ready = 0, update_game = 1, user_id = '0' WHERE game_id = ?";
        $statement = $dbh->prepare($query2);
        $statement->bindParam(1, $game_id, PDO::PARAM_STR);
        $statement->execute();
    }

       
    echo json_encode([
        'user1_ready' => $game_state['user1_ready'],
        'user2_ready' => $game_state['user2_ready'],
        'update' => $game_state['update_game'], 
        'user_id' => $game_state['user_id'],
        'user_id_2' => $_SESSION['user_id']
    ]);


?>