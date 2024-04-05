<?php
if (isset($_POST["email"]) && isset($_POST["password"])) {
      
    $conn = new mysqli("localhost", "root", "", "web_app_econ");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $sql = "SELECT *
    FROM users_ids
    WHERE email = '$email'
      AND password = '$password';
    ";
    if($conn->query($sql)){
        echo "Успешная авторизация";

    } else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();
}
?>