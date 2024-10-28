<?php
$dsn = 'mysql:host=localhost;dbname=book_exchange;charset=utf8';
$username = 'root';  // имя пользователя БД
$password = 'root';      // пароль БД

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}
?>