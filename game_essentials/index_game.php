<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('game_class.php');
$message = '';
$error = '';
$your_country = new Country();


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
<body>
  <div class="container" style="margin-top: 15px"> 
    <div class="card" style="background-color: darkseagreen;">  
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
        $error = '';
    }
  ?>
</div>
<div>
<?php
$message = $country['message'];
  if($message != '') {
      echo '<div class="alert alert-info">'.$message.'</div>';
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


