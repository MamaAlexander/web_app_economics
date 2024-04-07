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
}
    if (empty($_POST["password2"])) {
        $error = "Введите пароль ещё раз";
    } else if ($result->num_rows > 0) {
        $error = "Этот e-mail уже используется";
    } else if (mb_strlen($_POST["password"], "UTF-8") < 8) {
        $error = "Пароль слишком короткий";
    } else if ($_POST["password"] != $_POST["password2"]) {
        $error = "Пароли не совпадают";
    } 
    if($error == ''){
    $sql = "INSERT INTO users_ids (name, email, password) VALUES ('$name', '$email', '$password')";
    
    if ($conn->query($sql)) {
        $error = "Данные успешно добавлены";
    } else {
        $error = "Ошибка: " . $conn->error;
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
    <h1>Registration page</h1>

    <?php
    if($error !== '') {
        if($error == "Данные успешно добавлены") {
            echo '<div class="alert alert-info">'.$error.'</div>';
        } else {
            echo '<div class="alert alert-danger">'.$error.'</div>';
        }
    }
    ?>

    <form method="POST">
        <label>Name:</label><br>
        <input type="name" name="name" id="name" required><br><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" id="email" required><br>

        <br>
        <label>Password:</label><br>
        <input type="password" name="password" id="password" required><br>

        <br>
        <label>Password again:</label><br>
        <input type="password" name="password2" id="password2" required><br>
        <br>
        
        <div class="text-center">
            <input type="submit" name="login" class="btn btn-primary" value="Sign up" />
            <a href="../index.php"><input type="button" name="login" class="btn btn-primary" value="Log in" ></a>
        </div>
    </form>
    <br>
</body>
</html>