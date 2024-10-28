<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

// Обработка удаления пользователя или книги
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_user'])) {
        $user_id = $_POST['delete_user'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        header("Location: admin.php");
        exit();
    }
    if (isset($_POST['delete_book'])) {
        $book_id = $_POST['delete_book'];
        $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$book_id]);
        header("Location: admin.php");
        exit();
    }
}

// Получение списка пользователей и книг
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
$stmt = $pdo->query("SELECT * FROM books");
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
</head>
<body>
    <h2>Панель администратора</h2>
    
    <h3>Пользователи:</h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['username']); ?> | <?php echo htmlspecialchars($user['email']); ?>
                <form action="admin.php" method="POST" style="display:inline;">
                    <input type="hidden" name="delete_user" value="<?php echo $user['id']; ?>">
                    <button type="submit">Удалить</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Книги:</h3>
    <ul>
        <?php foreach ($books as $book): ?>
            <li>
                <?php echo htmlspecialchars($book['title']); ?> от <?php echo htmlspecialchars($book['author']); ?>
                <form action="admin.php" method="POST" style="display:inline;">
                    <input type="hidden" name="delete_book" value="<?php echo $book['id']; ?>">
                    <button type="submit">Удалить</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>