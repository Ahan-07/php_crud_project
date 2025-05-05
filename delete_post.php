<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];
$sql = "DELETE FROM posts WHERE id=$id";
mysqli_query($conn, $sql);
header('Location: blog.php');
?>
