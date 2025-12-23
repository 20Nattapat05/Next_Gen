<?php

function db()
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            $host = 'localhost';
            $dbname = 'nextgen_db';
            $charset = 'utf8';

            $username = 'root';
            $password = '';

            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            // connect database
            $pdo = new PDO($dsn, $username, $password, $options);

        } catch (PDOException $e) {
            // for production
            // die("ระบบฐานข้อมูลขัดข้อง กรุณาลองใหม่ภายหลัง");

            // for dev
            die($e->getMessage());
        }
    }

    return $pdo;
}

?>