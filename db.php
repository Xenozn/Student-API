<?php
function getPDO() {
    static $pdo = null;

    if ($pdo === null) {
        $host = 'localhost';
        $port = 3306;
        $dbname = 'api_notes';
        $username = 'root';
        $password = 'root';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    return $pdo;
}

