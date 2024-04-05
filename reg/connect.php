<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $conn = mysqli_connect('localhost', 'root', 'your_password', 'web_app_econ', '3306', '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock') or die("Connection Failed:" .mysqli_connect_error());
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "INSERT INTO 'users_ids' ('name', 'email', 'password') VALUES ('$name', '$email', '$password')";
        $query = mysqli_query($conn, $sql);
        if($query) {
            echo 'Entry Successfull';
        }
        else {
            echo 'Error Occured';
        }
    }
}
?>