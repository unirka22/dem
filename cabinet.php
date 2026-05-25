<?php
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT r.*, ro.name as room_name, ro.type as room_type 
          FROM requests r 
          JOIN rooms ro ON r.room_id = ro.id 
          WHERE r.user_id = $user_id 
          ORDER BY r.created_at DESC";
$requests = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Личный кабинет</h1>
        
        <nav>
            <a href="create_request.php">Создать заявку</a>
            <a href="logout.php">Выход</a>
        </nav>
        
        <h2>Мои заявки</h2>
        
        <table>
            <tr>
                <th>№</th>
                <th>Помещение</th>
                <th>Тип</th>
                <th>Дата начала</th>
                <th>Оплата</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($requests)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['room_name']; ?></td>
                <td><?php echo $row['room_type']; ?></td>
                <td><?php echo date('d.m.Y H:i', strtotime($row['date_start'])); ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <?php if ($row['status'] == 'Мероприятие завершено'): ?>
                        <a href="add_review.php?id=<?php echo $row['id']; ?>">Оставить отзыв</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        
        <h2>Мои отзывы</h2>
        
        <?php
        $reviews_query = "SELECT rev.*, ro.name as room_name 
                          FROM reviews rev 
                          JOIN requests req ON rev.request_id = req.id 
                          JOIN rooms ro ON req.room_id = ro.id 
                          WHERE rev.user_id = $user_id 
                          ORDER BY rev.created_at DESC";
        $reviews = mysqli_query($conn, $reviews_query);
        ?>
        
        <?php while ($review = mysqli_fetch_assoc($reviews)): ?>
        <div class="review">
            <strong><?php echo $review['room_name']; ?></strong>
            <p><?php echo $review['text']; ?></p>
            <small><?php echo date('d.m.Y H:i', strtotime($review['created_at'])); ?></small>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>