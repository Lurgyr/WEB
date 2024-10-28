<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->execute([$username, $email, $user_id]);

    $_SESSION['username'] = $username; // Обновляем имя в сессии
    header("Location: profile.php");
    exit();
}
?>