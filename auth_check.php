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
      AND password = '$password';";
    $result = $conn->query($sql);
    if($result->num_rows >= 1){
        echo "Успешная авторизация" . "<br>";
        echo '<a href="profile/profile.php">Перейти в личный кабинет</a>';
        die();
    } else{
        echo "Неверный email или пароль" . "<br>";
        echo '<a href="index.php">Попробовать ещё раз</a>';

    }
    $conn->close();
}
?>