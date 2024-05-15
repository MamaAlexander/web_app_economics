<?php
session_start();
if ($_COOKIE["user_id"] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../index.php');
    exit();
}
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
<div style="align-items: right"><a href='../profile/profile.php'>Go to profile</a></div>
  <div class="container">
    <div class="text-right mt-5 mb-5">
      <form method="POST" action="index_game.php"> 
      <h1>Name your country:</h1>
      <div style="text-align: centr">
        <input type="text" name="country_name" class="form-control" style="margin-top: 20px; width: 300px"/>
      </div>
    <input type="submit" name="submit" class="btn btn-primary" value="Submit" style="margin-top: 20px"/>
    </form>
  </div>
</div>
</body>
</html>