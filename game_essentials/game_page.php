<?php
session_start();
if ($_SESSION['user_id'] == '') {
  $_SESSION['message'] = 'You need to authorise first';
  header('Location: ../index.php');
  exit();
}
require_once('../db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Country Simulator</title>
  <link rel="stylesheet" href="styles.css">
  <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url(../v904-nunny-012.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh; /* Задаем высоту равной высоте экрана */
        }
        #resized {
          border-radius: 20px; 
          overflow: hidden; 
          min-heigt: 40px; 
          outline: 4px black solid;
        }
    </style>

</head>
<body>
<div style="margin-top: -30px; margin-right: 15px; float: right;" id="resized"><a href="../profile/profile.php"><input type="button" name="login" class="btn btn-light" value="Go to profile"></a></div>
  <div class="container">
    <div class="text-right mt-5 mb-5">
      <?php
      $sth = $dbh->prepare("SELECT * FROM web_session WHERE cookie_id = :cookie_id and user_id = :user_id");
      $session_id = $_SESSION['session_id'];
      $user_id = $_SESSION['user_id'];
      $sth->execute(array('cookie_id' => $session_id, 'user_id' => $user_id));
      $array = $sth->fetch(PDO::FETCH_ASSOC);
      
      if ($array['country_id'] == 0) {
        echo '<form method="POST" action="index_game.php"> 
        <h1>Name your country:</h1>
        <div style="text-align: centr">
          <input type="text" name="country_name" class="form-control" style="margin-top: 20px; width: 300px" placeholder="Country name"/>
        </div>
      <input type="submit" name="submit" class="btn btn-dark" value="Submit" style="margin-top: 20px"/>
      </form>';
      } else {
        echo '<a href="index_game.php"><input type="button" name="button2" class="btn btn-dark" value="Go to the game"></a>
        <a href="../logout.php"><button type="button" class="btn btn-light">Start new game</button></a>';
      }
      ?>
  </div>
</div>
</body>
</html>