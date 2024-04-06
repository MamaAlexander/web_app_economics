<?php 
$email = $_POST["email"];
$password = $_POST["password"];
?>

<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;

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

    $query = "SELECT * FROM user WHERE user_email = ?";
		$statement = $connect->prepare($query);
		$statement->execute([$_POST["email"]]);
		$data = $statement->fetch(PDO::FETCH_ASSOC);
    if($result->num_rows >= 1 && $data['password'] == $_POST["password"]) {
        $key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';
        $token = JWT::encode(
            array(
                'iat'		=>	time(),
                'nbf'		=>	time(),
                'exp'		=>	time() + 3600*24,
                'data'	=> array(
                    'email'	=>	$data['email']
                )
            ),
            $key,
            'HS256'
        );
        setcookie("token", $token, time() +3600*24, "/", "", true, true);
        echo "Успешная авторизация" . "<br>";
        echo '<a href="profile/profile.php">Перейти в личный кабинет</a>';
        die();

    } else {
        echo "Неверный email или пароль" . "<br>";
        echo '<a href="index.php">Попробовать ещё раз</a>';

    }
    $conn->close();
}
?>