<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../db.php');
$error = "";


if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password2"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $key = md5(microtime(true));

    $sql2 = "SELECT COUNT(*) FROM users_ids WHERE email = :email";
    $sth = $dbh->prepare($sql2);
    $sth->bindParam(':email', $email, PDO::PARAM_STR);
    $sth->execute();
    $num = $sth->fetchColumn();

    if ($num > 0) {
        $error = "Этот e-mail уже используется";
    } else if (mb_strlen($password, "UTF-8") < 8) {
        $error = "Пароль слишком короткий";
    } else if ($password != $_POST["password2"]) {
        $error = "Пароли не совпадают";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users_ids (user_id, name, email, password, last_session, is_verified) VALUES (:key, :name, :email, :password, '0', 'Not Verified')";
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':key', $key, PDO::PARAM_STR);
        $sth->bindParam(':name', $name, PDO::PARAM_STR);
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($sth->execute()) {
            $error = "Данные успешно добавлены";
        } else {
            $error = "Ошибка при добавлении данных";
        }
    }
}
include_once('registration.html');
?>