<?php
include 'game_class.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Document</title>
</head>
<body>
<div class="container">
  <h1 class="text-center mt-5 mb-5">Web App for Economics</h1>
  <div class="row">
    <div class="col-md-4">&nbsp;</div>
      <div class="col-md-4">

      <form action = 'game_class.php' method = 'post'>
      <div class="mb-3">
        <label>Name your country:</label>
        <input type="text" name="name" class="form-control" />
      </div>
      <div class="text-center">
        <input type="submit" name="login" class="btn btn-primary" value="Submit" />
      </div>
      </form>
      <br>
      <div class="row"
      <div class="col-md-4">
        <?php
          if($_POST['name'] != '') {
              echo '<div class="alert alert-info">'.'Your country is ' . $your_country->get_name() . ' with ' . $your_country->get_gpd() .' number of GPD and ' . $your_country->get_gov_budget() . ' number of government budget!'.'</div>';
          }
        ?>
      </div>
      </div>
  </div>
</div>
</body>
</html>