<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header('Location: login.php');
    exit;
}

$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $room_id = $_POST['room_id'];
    $date_start = $_POST['date_start'];
    $payment_method = $_POST['payment_method'];
    
    $query = "INSERT INTO requests (user_id, room_id, date_start, payment_method) 
              VALUES ($user_id, $room_id, '$date_start', '$payment_method')";
    
    if (mysqli_query($conn, $query)) {
        $success = 'Заявка успешно создана!';
    }
}

$rooms = mysqli_query($conn, "SELECT * FROM rooms");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Создание заявки</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Создание заявки</h1>
        
        <nav>
            <a href="cabinet.php">Назад в кабинет</a>
        </nav>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <label>Помещение:</label>
            <select name="room_id" required>
                <option value="">Выберите помещение</option>
                <?php while ($room = mysqli_fetch_assoc($rooms)): ?>
                    <option value="<?php echo $room['id']; ?>">
                        <?php echo $room['name'] . ' (' . $room['type'] . ')'; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <label>Дата и время начала:</label>
            <input type="datetime-local" name="date_start" required>
            
            <label>Способ оплаты:</label>
            <select name="payment_method" required>
                <option value="">Выберите способ оплаты</option>
                <option value="Наличные">Наличные</option>
                <option value="Безналичный">Безналичный</option>
                <option value="Банковская карта">Банковская карта</option>
            </select>
            
            <button type="submit">Создать заявку</button>
        </form>
    </div>
</body>
</html>