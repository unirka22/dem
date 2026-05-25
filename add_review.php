<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$request_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = $_POST['text'];
    
    $query = "INSERT INTO reviews (user_id, request_id, text) VALUES ($user_id, $request_id, '$text')";
    mysqli_query($conn, $query);
    
    header('Location: cabinet.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавить отзыв</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Оставить отзыв</h1>
        
        <form method="POST">
            <textarea name="text" placeholder="Ваш отзыв" required rows="5"></textarea>
            <button type="submit">Отправить отзыв</button>
        </form>
        
        <p><a href="cabinet.php">Назад</a></p>
    </div>
</body>
</html>