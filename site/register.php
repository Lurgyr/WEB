<?php
include 'db.php';
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    $success = "Регистрация успешна! Вы можете войти в систему.";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2 style= "text-align:center">Регистрация</h2>
        <?php if ($success): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <form id="registerForm" action="register.php" method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</body>
</html>