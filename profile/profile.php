<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// welcome.php
session_start();
if ($_COOKIE["user_id"] == '') {
    $_SESSION['message'] = 'You need to authorise first';
    header('Location: ../index.php');
    exit();
}

$user_id = $_COOKIE["user_id"];
// $conn = new mysqli("localhost", "root", "", "web_app_econ");
// if ($conn->connect_error) {
//     $error = "Ошибка: " . $conn->connect_error;
// }

$dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
$sth = $dbh->prepare("SELECT * FROM users_ids WHERE user_id = :id");
$sth->execute(['id' => $user_id]);
$array = $sth->fetch(PDO::FETCH_ASSOC);
$name = $array['name'];
// $sql = "UPDATE users_ids 
//         SET is_verified = 'Verified'
//         WHERE email = '. $decoded->data->email .'";
// $result = $conn->query($sql);

// $key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';

// if(isset($_COOKIE['token'])){
// 	$decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
// } else {
// 	header('location:index.php');
// }
echo $_COOKIE["user_id"];

?>

<!doctype html>
<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
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
						echo $name;
						?>
					</b></h1>
					<div style="margin-top: 40px">
					<a href="../game_essentials/game_page.php"><input type="button" name="button" class="btn btn-primary" value="Go to the game"></a>
					<a href="../logout.php"><input type="button" name="button" class="btn btn-primary" value="Exit"></a>
					</div>
				</div>
	    	</div>
    	</div>
  	</body>
</html>