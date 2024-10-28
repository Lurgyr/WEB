<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обмен книгами</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="container">
        <h1 style= "text-align:center" >Добро пожаловать в библиотеку буккроссинга</h1>
        <p style="text-align:center; font-size:1.2rem; color:#6b4226;">
            Здесь вы можете скачать или поделиться любимыми книгами с другими читателями.
        </p>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Здравствуйте, <?php echo $_SESSION['username']; ?>!</p>
            <a href="profile.php">Профиль</a> | <a href="book_list.php">Список книг</a> | <a href="logout.php">Выйти</a>
        <?php else: ?>
            <a href="register.php">Регистрация</a> | <a href="login.php">Вход</a> | <a href="book_list.php">Список книг</a>
        <?php endif; ?>
    </div>
</body>
</html>