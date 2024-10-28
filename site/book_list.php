<?php
session_start();
include 'db.php';

// Обработка скачивания
if (isset($_GET['download']) && isset($_SESSION['user_id'])) {
    $book_id = $_GET['download'];
    $user_id = $_SESSION['user_id'];

    // Добавление записи о скачивании в таблицу downloads
    $stmt = $pdo->prepare("INSERT INTO downloads (user_id, book_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $book_id]);

    // Перенаправление на файл для скачивания
    $stmt = $pdo->prepare("SELECT file_path FROM books WHERE id = ?");
    $stmt->execute([$book_id]);
    $book = $stmt->fetch();
    
    if ($book) {
        $file_path = $book['file_path'];
        header("Location: $file_path");
        exit();
    }
}

// Получение списка книг
$stmt = $pdo->query("SELECT books.*, users.username AS owner FROM books JOIN users ON books.owner_id = users.id");
$books = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список книг</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>Доступные книги для скачивания</h2>
        <ul class="book-grid">
            <?php foreach ($books as $book): ?>
                <li>
                    <img src="book.jpg" alt="Book Cover" class="book-cover">
                    <div class="book-info">
                        <strong><?php echo htmlspecialchars($book['title']); ?></strong><br>
                        <span>Автор: <?php echo htmlspecialchars($book['author']); ?></span>
                        <span>Жанр: <?php echo htmlspecialchars($book['genre']); ?></span>
                        <span>Загрузил: <?php echo htmlspecialchars($book['owner']); ?></span>
                        <?php if ($book['file_path']): ?>
                            <br><a href="book_list.php?download=<?php echo $book['id']; ?>" class="download-link">Скачать книгу</a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>