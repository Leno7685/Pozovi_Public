<?php
$dsn = 'mysql:host=localhost;dbname=leon;charset=utf8';
$username = 'leon';
$password = 'PRIVATE';
$database= "leon";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Greska!' . $e->getMessage());
}
?>