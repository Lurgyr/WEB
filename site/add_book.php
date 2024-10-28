<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $owner_id = $_SESSION['user_id'];

    // Обработка загрузки файла
    if (isset($_FILES['book_file']) && $_FILES['book_file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['book_file']['name']);
        $filePath = $uploadDir . $fileName;

        // Переместить загруженный файл в каталог 'uploads'
        if (move_uploaded_file($_FILES['book_file']['tmp_name'], $filePath)) {
            // Сохранить информацию о книге в базе данных
            $stmt = $pdo->prepare("INSERT INTO books (title, author, genre, owner_id, file_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $author, $genre, $owner_id, $filePath]);

            header("Location: profile.php");
            exit();
        } else {
            echo "Ошибка при загрузке файла.";
        }
    } else {
        echo "Пожалуйста, выберите файл для загрузки.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="container">
        <h2>Добавить книгу</h2>
        <form action="add_book.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Название книги" required>
            <input type="text" name="author" placeholder="Автор" required>
            <input type="text" name="genre" placeholder="Жанр" required>
            <input type="file" name="book_file" accept=".pdf,.epub" required>
            <button type="submit">Добавить</button>
        </form>
    </div>
</body>
</html>