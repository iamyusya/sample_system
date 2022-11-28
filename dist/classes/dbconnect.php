<?php
require_once './env.php';

    // DB接続
    function connect() {
        $db_host = DB_HOST;
        $db_name = DB_NAME;
        $db_user = DB_USER;
        $db_password = DB_PASSWORD;
        
        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
        
        try {
            $pdo = new PDO($dsn, $db_user, $db_password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $pdo;
        } catch(PDOException $e) {
            echo '接続失敗' . $e->getMessage();
            exit();
        }
    }

?>