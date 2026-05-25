<?php
include 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fio = $_POST['fio'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    $query = "INSERT INTO users (login, password, fio, phone, email) VALUES ('$login', '$password', '$fio', '$phone', '$email')";
    
    if (mysqli_query($conn, $query)) {
        $success = 'Регистрация успешна!';
    } else {
        $error = 'Ошибка регистрации';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="login" placeholder="Логин (мин. 6 символов)" required minlength="6">
            <input type="password" name="password" placeholder="Пароль (мин. 8 символов)" required minlength="8">
            <input type="text" name="fio" placeholder="ФИО" required>
            <input type="tel" name="phone" placeholder="Телефон" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
        
        <p><a href="login.php">Уже зарегистрированы? Войти</a></p>
    </div>
</body>
</html>