<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'statistici_droguri');
define('DB_USER', 'web_user');
define('DB_PASS', 'SCHIMBA_PAROLA_AICI');
define('DB_CHARSET', 'utf8mb4');

define('GROQ_API_KEY', 'PUNE_CHEIA_GROQ_AICI');

define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'SCHIMBA_PAROLA_ADMIN_AICI');

function getConnection(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
    return $pdo;
}
