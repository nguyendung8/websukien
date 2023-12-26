<?php

   include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id']; //tạo session người dùng thường

   if(!isset($user_id)){// session không tồn tại => quay lại trang đăng nhập
      header('location:login.php');
   }
   $event_id = $_GET['event_id'];

   // Lấy ra thông tin sách
   $sql = "SELECT * FROM events WHERE id = $event_id";
   $result = $conn->query($sql);
   $eventItem = $result->fetch_assoc();

   // Lấy ra thông tin user
   $sql1 = "SELECT * FROM users WHERE id = $user_id";
   $result1 = $conn->query($sql1);
   $user = $result1->fetch_assoc();
   
   $userId = $user_id;
   $userName = $user['name'];
   $event_name = $eventItem['name'];
   $event_img = $eventItem['image'];
   $email = $user['email'];

   $select_event_name = mysqli_query($conn, "SELECT event_name FROM `schedules` WHERE event_id = '$event_id'") or die('query failed');//truy vấn kiểm tra sự kiện đã tồn tại chưa
   if(mysqli_num_rows($select_event_name) > 0){
      echo '<script type="text/javascript">';
      echo 'alert("Bạn đã đăng ký tham dự sự kiện này rồi!.");';
      echo '</script>';
      header('location: home.php');
   }else{
      mysqli_query($conn, "INSERT INTO `schedules`(user_id, event_id, event_name, event_img, user_name, email) VALUES('$userId', '$event_id', '$event_name', '$event_img', '$userName', '$email')") or die('query failed');
      echo '<script type="text/javascript">';
      echo 'alert("Đăng ký tham dự sự kiện thành công!.");';
      echo '</script>';
      header('location: home.php');
   }
?>