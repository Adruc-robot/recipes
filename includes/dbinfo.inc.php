<?php
    $user = "php_dude";
    $host = "localhost:3306";
    $pass = "Op1inion2";
    $db = "food_stuffs";
    $charset = "utf8mb4";
    $dns = "mysql:host={$host};dbname={$db};charset={$charset}";
    $opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    );
?>