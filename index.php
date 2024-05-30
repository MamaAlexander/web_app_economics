<?php
$title = "Main Page";
error_reporting(E_ALL);
ini_set('display_errors', 1);

function get_user_id($email) {
    try {
        $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
        $sth = $dbh->prepare("SELECT * FROM users_ids WHERE `email` = :email");
        $sth->execute(array('email' => $email));
        $array = $sth->fetch(PDO::FETCH_ASSOC);
        return $array['user_id'];
    } catch (PDOException $e) {
        error_log("Ошибка подключения: " . $e->getMessage());
        die($e->getMessage());
        return null;
    } finally {
        $dbh = null;
        $sth = null;
    }
}
$error = "";
if (isset($_COOKIE['message'])) {
	$error = $_COOKIE['message'];
    // echo $_COOKIE['message'];
    setcookie("message", "", time() - 3600, "/");;
}


date_default_timezone_set('Etc/GMT+3');

// $email = $_POST["email"];
// $password = $_POST["password"];

// if($error != "Данные успешно добавлены"){
//     $error = "";
// }


if (isset($_POST["email"]) && isset($_POST["password"])) {
    $connect = new PDO("mysql:host=localhost;dbname=web_app_econ", "root", "");
    $conn = new mysqli("localhost", "root", "", "web_app_econ");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $sql = "SELECT * FROM users_ids WHERE email = '$email' AND password = '$password';";
    $result = $conn->query($sql);

    $query = "SELECT * FROM users_ids WHERE email = ?";
    $statement = $connect->prepare($query);
    $statement->execute([$_POST["email"]]);
    $data = $statement->fetch(PDO::FETCH_ASSOC);
    
    if($result->num_rows >= 1 && $data['password'] == $_POST["password"]) {
        session_start();

        $sql4 = "SELECT * from users_ids
        where email = '$email'";
        $result = $conn->query($sql4);
        $row = $result->fetch_assoc(); // Получаем строку из результата
        $user_id = $row['user_id']; 
        $name = $row['name'];
        $_SESSION['user_id'] = $user_id; 
        $_SESSION['name'] = $name; 
        $_SESSION['session_id'] = md5(microtime(true));

        $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
        $sql = "INSERT INTO web_session (cookie_id, user_id) VALUES (:session_id, :user_id)";
        $sth = $dbh->prepare($sql);
        $session_id = $_SESSION['session_id'];
        $sth = $dbh->prepare($sql);
        $sth->execute(array('session_id' => $session_id, 'user_id' => $user_id));

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
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url(v904-nunny-012.jpg);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh; /* Задаем высоту равной высоте экрана */
        }
        #resized {
            border-radius: 20px;
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
                    if($error == "Данные успешно добавлены") {
                        echo '<div class="alert alert-info">'.$error.'</div>' ;
                    }else 
                    if($error !== '')
    				{
    					echo '<div class="alert alert-danger">'.$error.'</div>';
    				}
                    session_start();
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['message'] . '</div>' ;
                        unset($_SESSION['message']);                    
                    }
    				?>
            <div class='d-flex justify-content-center'>
            <object type="image/svg+xml" data="icon.svg">
            </object>
            </div>
            <div class='d-flex justify-content-center'><h2>Log in</h2></div>
		    		<!-- <div class="card"> -->
		    			<div class="card-body">
		    				<form method="post">
		    					<div class="mb-3">
			    					<!-- <label style="margin-right: auto; margin-left: auto;">Email</label> -->
                                    <input type="email" name="email" class="form-control" id='resized' placeholder="Email"/>
			    				</div>
			    				<div class="mb-3">
			    					<!-- <label style="margin-right: auto; margin-left: auto;">Password</label> -->
			    					<input type="password" name="password" class="form-control" id='resized' placeholder="Password"/>
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" name="login" class="btn btn-dark" value="Log in" />
                                    <a href="reg/registration.php"><input type="button" name="login" class="btn btn-light" value="Sing up"></a>
			    				</div>
		    				</form>
		    			</div>
		    		<!-- </div> -->
		    	</div>
	    	</div>
    	</div>
  	</body>
</html>

