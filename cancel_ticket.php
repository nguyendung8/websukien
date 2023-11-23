<?php
    include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id']; //tạo session người dùng thường

    if(!isset($user_id)){// session không tồn tại => quay lại trang đăng nhập
    header('location:login.php');
    }
    $ticket_id = $_GET['ticket_id'];

    mysqli_query($conn, "DELETE FROM `tickets` WHERE id = '$ticket_id'") or die('query failed');
    header('location:tickets.php');

?>