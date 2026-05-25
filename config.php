<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'user22';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_set_charset($conn, 'utf8');
?>