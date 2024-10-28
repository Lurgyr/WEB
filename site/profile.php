<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = "";

// Получение данных пользователя
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Обработка формы изменения данных пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->execute([$username, $email, $user_id]);
    $success = "Данные обновлены!";
}

// Получение книг, загруженных пользователем
$stmt = $pdo->prepare("SELECT * FROM books WHERE owner_id = ?");
$stmt->execute([$user_id]);
$uploaded_books = $stmt->fetchAll();

// Получение книг, скачанных пользователем
$stmt = $pdo->prepare("SELECT books.* FROM downloads JOIN books ON downloads.book_id = books.id WHERE downloads.user_id = ?");
$stmt->execute([$user_id]);
$downloaded_books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>Ваш профиль</h2>
        <?php if ($success): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" action="profile.php">
            <label>Имя пользователя:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <button type="submit" name="update_user">Сохранить изменения</button>
        </form>

        <h3>Ваши загруженные книги</h3>
        <ul>
            <?php foreach ($uploaded_books as $book): ?>
                <li><?php echo htmlspecialchars($book['title']); ?> от <?php echo htmlspecialchars($book['author']); ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Ваши скачанные книги</h3>
        <ul>
            <?php foreach ($downloaded_books as $book): ?>
                <li><?php echo htmlspecialchars($book['title']); ?> от <?php echo htmlspecialchars($book['author']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>