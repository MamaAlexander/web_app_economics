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

    $sql2 = "SELECT * FROM users_ids WHERE email = '$email'";
    $result = $conn->query($sql2);

    if ($result->num_rows > 0) {
        $error = "Этот e-mail уже используется";
    } else if (mb_strlen($_POST["password"], "UTF-8") < 8) {
        $error = "Пароль слишком короткий";
    } else if ($_POST["password"] != $_POST["password2"]) {
        $error = "Пароли не совпадают";
    } else {
        $sql = "INSERT INTO users_ids (name, email, password, last_session) VALUES ('$name', '$email', '$password', '0')";
    
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
            <svg width="82" height="82" viewBox="0 0 82 82" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M70.6686 68.9797C77.6086 61.6541 81.8645 51.7657 81.8645 40.8843C81.8645 18.3045 63.5385 0 40.9323 0C18.326 0 0 18.3045 0 40.8843C0 51.4026 3.97667 60.9932 10.5102 68.2379C11.013 52.0809 24.2843 39.1371 40.5824 39.1371C57.1291 39.1371 70.5561 52.4788 70.6686 68.9797Z" fill="#BFBFBF"/>
              <ellipse cx="40.5824" cy="20.9663" rx="13.2942" ry="13.2787" fill="white"/>
              <path d="M81.3645 40.8843C81.3645 63.1874 63.2629 81.2686 40.9323 81.2686C18.6016 81.2686 0.5 63.1874 0.5 40.8843C0.5 18.5812 18.6016 0.5 40.9323 0.5C63.2629 0.5 81.3645 18.5812 81.3645 40.8843Z" stroke="white"/>
              </svg>
            </div>
            <div class='d-flex justify-content-center'><h2>Sign up</h2></div>
		    		<div class="card">
		    			<div class="card-body">
		    				<form method="post">
                            <div class="mb-3">
			    					<label>Name</label>
			    					<input type="name" name="name" class="form-control" required />
			    				</div>
		    					<div class="mb-3">
			    					<label>Email</label>
			    					<input type="email" name="email" class="form-control" required />
			    				</div>
			    				<div class="mb-3">
			    					<label>Password</label>
			    					<input type="text" name="password" class="form-control" required />
			    				</div>
			    				<div class="mb-3">
			    					<label>Password again</label>
			    					<input type="text" name="password2" class="form-control" required />
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" name="login" class="btn btn-primary" value="Sign up" />
                                    <a href="../index.php"><input type="button" name="login" class="btn btn-primary" value="Log in"></a>
			    				</div>
		    				</form>
		    			</div>
		    		</div>
		    	</div>
	    	</div>
    	</div>
    <br>
</body>
</html>






            