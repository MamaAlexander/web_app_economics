<?php
// Отображение ошибок на странице index_game
$error = $country['error'];
if($error != '') {
    echo '<div><div class="alert alert-danger">'.$error.'</div></div>';
    $your_country->set_country_data('error', '');
    $error = '';
}

// Отображение сообщений на странице index_game
$message = $country['message'];
  if($message != '') {
    echo '<div> <div class="alert alert-info" style="margin-right: 30px; margin-left: 30px;">'.$message.'</div> </div>';
    $your_country->set_country_data('message', '');
    $message = '';
  } 
  if (isset($_GET['game_id'])) {
    echo '<div> <div class="alert alert-info" style="margin-right: 30px; margin-left: 30px;">' . 'You started the game. Provide this number to Player 2:' . $_GET['game_id'] . '</div> </div>';
  }
?>