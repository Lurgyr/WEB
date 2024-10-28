<?php
include 'db.php';
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = $_POST['identifier']; // Логин или email
    $password = $_POST['password'];

    // Запрос, проверяющий, есть ли такой пользователь по логину или email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: profile.php");
        exit();
    } else {
        $error = "Неверный логин, email или пароль!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Вход</h2>
        <?php if ($error): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="identifier" placeholder="Логин или Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>