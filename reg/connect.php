<?php
if (!isset($_POST["password2"])) {
    echo "Введите пароль ещё раз" . "<br>";
    echo '<a href="reg/registration.php">Попробовать ещё раз</a>';
    die();
}

$conn = new mysqli("localhost", "root", "", "web_app_econ");

if ($conn->connect_error) {
    echo '<a href="reg/registration.php">Попробовать ещё раз</a>';
    die("Ошибка: " . $conn->connect_error);
}

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password2"])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);

    $sql2 = "SELECT * FROM users_ids WHERE email = '$email'";
    $result = $conn->query($sql2);

    if ($result->num_rows > 0) {
        echo "Этот e-mail уже используется" . "<br>";
        echo '<a href="registration.php">Попробовать ещё раз</a>';
        die();
    }

    if (mb_strlen($password, "UTF-8") < 8) {
        echo "Пароль слишком короткий" . "<br>";
        echo '<a href="registration.php">Попробовать ещё раз</a>';
        die();
    }
    
    if ($password != $password2) {
        echo "Пароли не совпадают" . "<br>";
        echo '<a href="registration.php">Попробовать ещё раз</a>';
        die();
    }

    $sql = "INSERT INTO users_ids (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql)) {
        echo "Данные успешно добавлены";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

$conn->close();
?>