<?php
        // $key = '1a3LM3W966D6QTJ5BJb9opunkUcw_d09NCOIJb9QZTsrneqOICoMoeYUDcd_NfaQyR787PAH98Vhue5g938jdkiyIZyJICytKlbjNBtebaHljIR6-zf3A2h3uy6pCtUFl1UhXWnV6madujY4_3SyUViRwBUOP-UudUL4wnJnKYUGDKsiZePPzBGrF4_gxJMRwF9lIWyUCHSh-PRGfvT7s1mu4-5ByYlFvGDQraP4ZiG5bC1TAKO_CnPyd1hrpdzBzNW4SfjqGKmz7IvLAHmRD-2AMQHpTU-hN2vwoA-iQxwQhfnqjM0nnwtZ0urE6HjKl6GWQW-KLnhtfw5n_84IRQ';
        // $token = JWT::encode(
        //     array(
        //         'iat'	=>	time(),
        //         'nbf'	=>	time(),
        //         'exp'	=>	time() + 3600*24,
        //         'data'	=>      array(
        //         'name'	=>	$data['name'],
        //         'email'	=>	$data['email']
        //         )
        //     ),
        //     $key,
        //     'HS256'
        // );
        // setcookie("token", $token, time() + 3600*24, "/", "", true, true);
        // // $error = "Успешная авторизация";
        
        // $temp = date('m/d/Y h:i:s a', time());
        // $sql3 = "UPDATE users_ids
        // SET last_session = '$temp'
        // WHERE email = '$email';";
        // $result = $conn->query($sql3);
      

        // $user_id = get_user_id($_POST["email"]);
        // $decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
        // $dbh = new PDO('mysql:dbname=web_app_econ;host=localhost', 'root', '');
        // $count_id = md5(microtime(true));
        // $filename = __DIR__ . '/country_id.txt';
        // file_put_contents($filename, $count_id);
        // $sth = $dbh->prepare("INSERT INTO web_session (token, user_id) 
        //                      VALUE (:token, :user_id);");
        // $sth->execute(array('token' => $decoded, 'user_id' => $user_id));
?>