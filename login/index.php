<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../db.php');

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
    // проверка пароля и почты и внесение записи в таблицу web_session
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

        header('location: ../profile/profile.php');
    } else {
        $error = "Неверный email или пароль";
    }
}
include_once('index.html');
?>
