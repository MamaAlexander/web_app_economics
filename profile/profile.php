<?php

// welcome.php

require '../vendor/autoload.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$conn = new mysqli("localhost", "root", "", "web_app_econ");
if ($conn->connect_error) {
    $error = "Ошибка: " . $conn->connect_error;
}

// $sql = "UPDATE users_ids 
//         SET is_verified = 'Verified'
//         WHERE email = '. $decoded->data->email .'";
// $result = $conn->query($sql);

$key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';

if(isset($_COOKIE['token'])){
	$decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
} else {
	header('location:index.php');
}
?>

<!doctype html>
<html lang="en">
  	<head>
    	<!-- Required meta tags -->
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

    	<!-- Bootstrap CSS -->
    	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    	<title>Profile</title>
  	</head>
  	<body>
    	<div class="container">
    		<h1 class="text-center mt-5 mb-5">Profile</h1>
    		<div class="row">
    			<div class="col-md-4">&nbsp;</div>
    			<div class="col-md-4 text-center">
    				<h1>Welcome <b>
                        <?php 
                        echo $decoded->data->name; 
                        ?>
                        </b></h1>
						<a href="../game_essentials/game_page.php">Go to the game</a>
    				<a href="../logout.php">Exit</a>
    				
		    	</div>
	    	</div>
    	</div>
  	</body>
</html>