<?php
    $title = "Main Page";
?>
<?php 
date_default_timezone_set('Russia/Moscow');

$email = $_POST["email"];
$password = $_POST["password"];

if($error != "Данные успешно добавлены"){
    $error = "";
}
require 'vendor/autoload.php';
use Firebase\JWT\JWT;

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $connect = new PDO("mysql:host=localhost;dbname=web_app_econ", "root", "");
    $conn = new mysqli("localhost", "root", "", "web_app_econ");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $sql = "SELECT *
    FROM users_ids
    WHERE email = '$email'
      AND password = '$password';";
    $result = $conn->query($sql);

    $query = "SELECT * FROM users_ids WHERE email = ?";
		$statement = $connect->prepare($query);
		$statement->execute([$_POST["email"]]);
		$data = $statement->fetch(PDO::FETCH_ASSOC);
    
    if($result->num_rows >= 1 && $data['password'] == $_POST["password"]) {
        $key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';
        $token = JWT::encode(
            array(
                'iat'		=>	time(),
                'nbf'		=>	time(),
                'exp'		=>	time() + 3600*24,
                'data'	=> array(
                    'email'	=>	$data['email']
                )
            ),
            $key,
            'HS256'
        );
        setcookie("token", $token, time() + 3600*24, "/", "", true, true);
        // $error = "Успешная авторизация";
        
        $temp = date('m/d/Y h:i:s a', time());
        $sql3 = "UPDATE users_ids
        SET last_session = '$temp'
        WHERE email = '$email';";
        $result = $conn->query($sql);
        header('location: profile/profile.php');

    } else {
        $error =  "Неверный email или пароль"; //  . "<br>" . '<a href="password_recovery.php">Забыли паароль?</a>'

    }
    $conn->close();
}
?>

<!-- css style -->
<style type="text/css" media="all">
@import url("index.css");
</style>
<!--  -->
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
    				<?php
                    if($error == "Данные успешно добавлены") {
                        echo '<div class="alert alert-info">'.$error.'</div>';
                    }else 
                    if($error !== '')
    				{
    					echo '<div class="alert alert-danger">'.$error.'</div>';
    				}

    				?>
            <div class='d-flex justify-content-center'>
            <svg width="82" height="82" viewBox="0 0 82 82" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M70.6686 68.9797C77.6086 61.6541 81.8645 51.7657 81.8645 40.8843C81.8645 18.3045 63.5385 0 40.9323 0C18.326 0 0 18.3045 0 40.8843C0 51.4026 3.97667 60.9932 10.5102 68.2379C11.013 52.0809 24.2843 39.1371 40.5824 39.1371C57.1291 39.1371 70.5561 52.4788 70.6686 68.9797Z" fill="#BFBFBF"/>
              <ellipse cx="40.5824" cy="20.9663" rx="13.2942" ry="13.2787" fill="white"/>
              <path d="M81.3645 40.8843C81.3645 63.1874 63.2629 81.2686 40.9323 81.2686C18.6016 81.2686 0.5 63.1874 0.5 40.8843C0.5 18.5812 18.6016 0.5 40.9323 0.5C63.2629 0.5 81.3645 18.5812 81.3645 40.8843Z" stroke="white"/>
              </svg>
            </div>
            <div class='d-flex justify-content-center'><h2>Log in</h2></div>
		    		<div class="card">
		    			<div class="card-body">
		    				<form method="post">
		    					<div class="mb-3">
			    					<label>Email</label>
			    					<input type="email" name="email" class="form-control" />
			    				</div>
			    				<div class="mb-3">
			    					<label>Password</label>
			    					<input type="password" name="password" class="form-control" />
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" name="login" class="btn btn-primary" value="Log in" />
                                    <a href="reg/registration.php"><input type="button" name="login" class="btn btn-primary" value="Sing up"></a>
			    				</div>
		    				</form>
		    			</div>
		    		</div>
		    	</div>
	    	</div>
    	</div>
  	</body>
</html>

