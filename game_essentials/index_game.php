<?php
session_start();
include_once('game_class.php');
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../index.php');
    exit();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = $_SESSION["user_id"];
$message = '';
$error = '';
$your_country = new Country();

$dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
$sth = $dbh->prepare("SELECT * FROM web_session WHERE cookie_id = :cookie_id and user_id = :user_id");
$session_id = $_SESSION['session_id'];
$user_id = $_SESSION['user_id'];
$sth->execute(array('cookie_id' => $session_id, 'user_id' => $user_id));
$array = $sth->fetch(PDO::FETCH_ASSOC);


if ($array['country_id'] == 0) {
  $your_country->set_new_country($_POST['country_name']);
}
$country = $your_country->get_country_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="index.css">
</head>
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
    </style>
<body>
<div style="margin-top: -40px; margin-right: 15px; float: right;"><a href="../profile/profile.php"><input type="button" name="login" class="btn btn-primary" value="Go to profile"></a></div>

  <div class="container" style="margin-top: 50px"> 
    <div class="card" style='background-color:cornflowerblue';">  
      <div class="row" style="align-items: center;">
        <div class="col">
          <?php
          echo '<b>' . $country['name'] . '</b>';
          ?>
        </div>
        <div class="col">
          <?php
          echo '<b>' . "GDP" . '</b>' ."<br>" . $country['gdp'];
          ?>
        </div>
        <div class="col">
          <?php
          echo '<b>' . "State budget status" . '</b>' . "<br>" . $country['gov_budget'];
          ?>
        </div>
        <div class="col">
          <?php
          echo '<b>' . "Rate of inflation" . '</b>' . "<br>" . $country['inf_rate'] . '%';
          ?>
        </div>
        <div class="col">
          <?php
          echo '<b>' . "Unemployment rate" . '</b>' . "<br>" . $country['unemploym_rate'] . '%';
          ?>
        </div>
        <div class="col">
          <?php
          echo '<b>' . "Number of steps last" . '</b>' . "<br>" . $country['num_of_steps'];
          ?>
      </div>
    </div>
  </div>
</div>
<div style="margin-right: 10px; margin-top: 10px;">
<p style="text-align:right;">
  <?php
  echo "Credits last" . "<br>" . $country['credits'];
  ?>
  </p>
</div>
<div>
  <?php
  $error = $country['error'];
    if($error != '') {
        echo '<div class="alert alert-danger">'.$error.'</div>';
        $your_country->set_country_data('error', '');
        $error = '';
    }
  ?>
</div>
<div>
<?php
$message = $country['message'];
  if($message != '') {
      echo '<div class="alert alert-info">'.$message.'</div>';
      $your_country->set_country_data('message', '');
      $message = '';
  }
?>
</div>
<h1 style='margin-top: 30px'>
<div style="margin-left: 20px">
<details>
<summary>Finance market</summary>
<p>Persent rate</p>
<p>Reservation rate</p>
<p>Issue of government bonds</p>
</details>

<details>
<summary>Households</summary>
<p>Transferts</p>
<p>Taxes</p>
</details>

<details>
<summary>Firms</summary>
<p>Transferts</p>
<p>Taxes</p>
</details>
</div>
</h1>
</body>
</html>


