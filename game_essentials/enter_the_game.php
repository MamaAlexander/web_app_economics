<?php
session_start();
if ($_SESSION['user_id'] == '') {
  $_SESSION['message'] = 'You need to authorise first';
  header('Location: ../index.php');
  exit();
}
$dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
$sth = $dbh->prepare("SELECT * FROM web_session WHERE cookie_id = :cookie_id and user_id = :user_id");
$session_id = $_SESSION['session_id'];
$user_id = $_SESSION['user_id'];
$sth->execute(array('cookie_id' => $session_id, 'user_id' => $user_id));
$array = $sth->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
  body {
      margin: 0;
      padding: 0;
      background-image: url(../v904-nunny-012.jpg);
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      height: 100vh;
  }
  #resized {
    border-radius: 20px; 
    overflow: hidden; 
    min-heigt: 40px; 
    outline: 4px black solid;
  }
  .button-wrapper{
    content: "";
  display: inline-block;
  height: 100%;
  vertical-align: middle;	
}
</style>
</head>
<body>

<?php
if ($array['country_id'] == 0) {
    echo '
    <div class="container" style="padding-top: 70px;"> 
        <div class="row">
            <div class="col" style="margin-bottom: 30px">
                <div class="row" style="align-items: center; margin-top: 20px; margin-bottom: 20px; margin-left: 15px; margin-right: 8px;">
                    <form method="POST" action="create_game.php"> 
                        <div class="d-flex justify-content-center"><h3>Create new game:</h3></div>
                        <div class="d-flex justify-content-center"><input type="text" name="country_name" class="form-control" style="margin-top: 30px; width: 300px" id="resized" placeholder="Country name"/></div>
                        <div class="d-flex justify-content-center"><input type="submit" name="submit" class="btn btn-dark" value="Create" style="margin-top: 30px;"/></div>
                    </form> 
                </div>
            </div>
            <div class="col">
                <div class="row" style="align-items: center; margin-top: 20px; margin-bottom: 20px; margin-left: 15px; margin-right: 8px;">
                    <form method="POST" action="join_game.php"> 
                        <div class="d-flex justify-content-center"><h3>Join game:</h3></div>
                        <div class="d-flex justify-content-center"><input type="text" name="game_id" class="form-control" style="margin-top: 30px; width: 300px" id="resized" placeholder="Game identificator"/></div>
                        <div class="d-flex justify-content-center"><input type="text" name="country_name" class="form-control" style="margin-top: 30px; width: 300px" id="resized" placeholder="Country name"/></div>
                        <div class="d-flex justify-content-center"><input type="submit" name="submit" class="btn btn-dark" value="Join" style="margin-top: 30px;" /></div>
                    </form> 
                </div>
            </div>
        </div>
    </div>';
} else {
    echo '
    <div class="container" style="display: flex; justify-content: center; margin-top: 55px;">
        <a href="index_game.php"><input type="button" name="button2" class="btn btn-dark" value="Go to the game" style="margin-right: 10px"></a>
        <a href="../logout.php"><button type="button" class="btn btn-light">Start new game</button></a>
    </div>';
}
?>

</body>
</html>