<?php
    session_start();
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "oligopolygame";
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=web_app_econ', 'root', '');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $_SESSION['dbh'] = $dbh;
    } catch (PDOException $e) {
        error_log("Ошибка подключения: " . $e->getMessage());
        die("Database connection failed: " . $e->getMessage());
    }
?>