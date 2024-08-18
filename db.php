<?php
    session_start();
    try {
        $dbh = new PDO('mysql:host=80.85.153.48;dbname=web_app_econ', 'remboplas', '053107720User!');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $_SESSION['dbh'] = $dbh;
    } catch (PDOException $e) {
        error_log("Ошибка подключения: " . $e->getMessage());
        die("Database connection failed: " . $e->getMessage());
    }
?>