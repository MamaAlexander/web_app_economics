<?php
$error = "";

$conn = new mysqli("localhost", "root", "", "web_app_econ");

if ($conn->connect_error) {
    $error = "Ошибка: " . $conn->connect_error;
}

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password2"])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $key = md5(microtime(true));

    $sql2 = "SELECT * FROM users_ids WHERE email = '$email'";
    $result = $conn->query($sql2);

    if ($result->num_rows > 0) {
        $error = "Этот e-mail уже используется";
    } else if (mb_strlen($_POST["password"], "UTF-8") < 8) {
        $error = "Пароль слишком короткий";
    } else if ($_POST["password"] != $_POST["password2"]) {
        $error = "Пароли не совпадают";
    } else {
        $sql = "INSERT INTO users_ids (user_id, name, email, password, last_session, is_verified) VALUES ('$key', '$name', '$email', '$password', '0', 'Not Verified')";
    
        if ($conn->query($sql)) {
            $error = "Данные успешно добавлены";
            // header('location: registration.php');
        } else {
            $error = "Ошибка: " . $conn->error;
        }
    }
}

$conn->close();
?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        #resized {
            width: 300px;
            /* text-align: center; */
            margin-right: auto;
	        margin-left: auto;
            outline: 4px black solid;
        }
        </style>
</head>
<body>
<div class="container">
    		<h1 class="text-center mt-5 mb-5">Web App for Economics</h1>
    		<div class="row">
    			<div class="col-md-4">&nbsp;</div>
    			<div class="col-md-4">

    <?php
    if($error !== '') {
        if($error == "Данные успешно добавлены") {
            echo '<div class="alert alert-info">'.$error.'</div>';
        } else {
            echo '<div class="alert alert-danger">'.$error.'</div>';
        }
    }
    ?>

<div class='d-flex justify-content-center'>
<object type="image/svg+xml" data="../icon.svg">
            </object>
            </div>
            <div class='d-flex justify-content-center'><h2>Sign up</h2></div>
		    		<!-- <div class="card"> -->
		    			<div class="card-body">
		    				<form method="post">
                            <div class="mb-3">
			    					<input type="name" name="name" class="form-control" id='resized' placeholder="Name" required />
			    				</div>
		    					<div class="mb-3">
			    					<input type="email" name="email" class="form-control" id='resized' placeholder="Email" required />
			    				</div>
			    				<div class="mb-3">
			    					<input type="password" name="password" class="form-control" id='resized' placeholder="Password" required />
			    				</div>
			    				<div class="mb-3">
			    					<input type="password" name="password2" class="form-control" id='resized' placeholder="Password again" required />
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" name="login" class="btn btn-dark" value="Sign up" />
                                    <a href="../index.php"><input type="button" name="login" class="btn btn-light" value="Log in"></a>
			    				</div>
		    				</form>
		    			</div>
		    		<!-- </div> -->
		    	</div>
	    	</div>
    	</div>
    <br>
</body>
</html>






            