<?php
$title = "Main Page";
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once('db.php');

// session_start(); // Start the session at the beginning

// function get_user_id($email) {
//     try {
//         $sth = $_SESSION['dbh']->prepare("SELECT * FROM users_ids WHERE `email` = :email");
//         $sth->execute(array(':email' => $email));
//         $array = $sth->fetch(PDO::FETCH_ASSOC);
//         return $array['user_id'];
//     } catch (PDOException $e) {
//         error_log("Ошибка подключения: " . $e->getMessage());
//         die($e->getMessage());
//     }
// }

$error = "";
if (isset($_COOKIE['message'])) {
    $error = $_COOKIE['message'];
    setcookie("message", "", time() - 3600, "/");
}

date_default_timezone_set('Etc/GMT+3');

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $dbh = new PDO('mysql:host=localhost;dbname=web_app_econ', 'root', '');

    $email = $_POST["email"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users_ids WHERE email = :email";
    $sth = $dbh->prepare($sql);
    $sth->execute([':email' => $email]);
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['password'])) {
        $user_id = $result['user_id'];
        $name = $result['name'];
        
        $_SESSION['user_id'] = $user_id; 
        $_SESSION['name'] = $name; 
        $_SESSION['session_id'] = md5(microtime(true));

        $sql = "INSERT INTO web_session (cookie_id, user_id) VALUES (:session_id, :user_id)";
        $sth = $dbh->prepare($sql);
        $session_id = $_SESSION['session_id'];
        $sth->execute([':session_id' => $session_id, ':user_id' => $user_id]);

        header('location: profile/profile.php');
    } else {
        $error = "Неверный email или пароль";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            height: 100vh;
        }
        #resized {
            border-radius: 20px;
            width: 300px;
            display-flex: center;
            margin-right: 0px;
            margin-left: 0px;
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
                if ($error !== '') {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                ?>
                <div class='d-flex justify-content-center'>
                    <object type="image/svg+xml" data="icon.svg"></object>
                </div>
                <div class='d-flex justify-content-center'><h2>Log in</h2></div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" id='resized' placeholder="Email" required/>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" id='resized' placeholder="Password" required/>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="login" class="btn btn-dark" value="Log in" />
                            <a href="reg/registration.php"><input type="button" name="login" class="btn btn-light" value="Sign up"></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
