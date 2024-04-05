<?php
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])) {
      
    $conn = new mysqli("localhost", "root", "", "web_app_econ");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $sql = "INSERT INTO users_ids (name, email, password) VALUES ('$name', '$email', '$password')";
    if($conn->query($sql)){
        echo "Данные успешно добавлены";

    } else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();
}
?>