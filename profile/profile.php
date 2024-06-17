<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SESSION['user_id'] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../index.php');
    exit();
}

$name = $_SESSION["name"];

?>

<!doctype html>
<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    	<title>Profile</title>
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
		
    </style>
  	</head>
  	<body>
    	<div class="container">
    		<h1 class="text-center mt-5 mb-5">Profile</h1>
    		<div class="row">
    			<div class="col-md-4">&nbsp;</div>
    			<div class="col-md-4 text-center">
    				<h1>Welcome <b>
                        <?php 
						echo $name;
						?>
					</b></h1>
					<div style="margin-top: 40px">
					<a href="../game_essentials/enter_the_game.php"><input type="button" name="button" class="btn btn-dark" value="Go to the game"></a>
					<a href="../logout.php"><input type="button" name="button" class="btn btn-light" value="Exit"></a>
					</div>
				</div>
	    	</div>
    	</div>
  	</body>
</html>