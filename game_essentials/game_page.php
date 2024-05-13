<?php
include_once('game_class.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Country Simulator</title>
</head>
<body>
  <div class="container">
  <div class="text-center mt-5 mb-5">
    <form method="POST" action="index.php"> 
      <h1>Name your country:</h1>
      <input type="text" name="country_name" class="form-control" />
      <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
    </form>
  </div>
  </div>
</body>
</html>