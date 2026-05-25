<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    
    $query = "UPDATE requests SET status='$status' WHERE id=$request_id";
    mysqli_query($conn, $query);
}

$query = "SELECT r.*, ro.name as room_name, ro.type as room_type, u.fio, u.phone, u.email 
          FROM requests r 
          JOIN rooms ro ON r.room_id = ro.id 
          JOIN users u ON r.user_id = u.id 
          ORDER BY r.created_at DESC";
$requests = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Панель администратора</h1>
        
        <nav>
            <a href="logout.php">Выход</a>
        </nav>
        
        <h2>Все заявки</h2>
        
        <table>
            <tr>
                <th>№</th>
                <th>Клиент</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Помещение</th>
                <th>Дата начала</th>
                <th>Оплата</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($requests)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['fio']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['room_name'] . ' (' . $row['room_type'] . ')'; ?></td>
                <td><?php echo date('d.m.Y H:i', strtotime($row['date_start'])); ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                        <select name="status">
                            <option value="Новая">Новая</option>
                            <option value="Мероприятие назначено">Мероприятие назначено</option>
                            <option value="Мероприятие завершено">Мероприятие завершено</option>
                        </select>
                        <button type="submit">Изменить</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>