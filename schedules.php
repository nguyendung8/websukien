<?php

   include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id']; //tạo session người dùng thường

   if(!isset($user_id)){// session không tồn tại => quay lại trang đăng nhập
      header('location:login.php');
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lịch trình</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      .borrow-container {
         display: flex;
         gap: 10px;
         flex-wrap: wrap;
      }
      .borrow-box {
         width: 325px;
         font-size: 19px;
         border: 2px solid #eee;
         border-radius: 4px;
         padding: 12px;
         box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
      }
      .borrow-box p {
         padding: 4px 0;
      }
      .cancel_ticket {
         border: 1px solid #ddd;
         padding: 4px 15px;
         border-radius: 4px;
         background: #ddb;
         color: red;
      }
      .cancel_ticket:hover {
         opacity: 0.8;
      }
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="placed-orders">

   <h1 class="title">Lịch trình của bạn</h1>

   <div class="borrow-container">

      <?php
         $register_query = mysqli_query($conn, "SELECT * FROM `schedules` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($register_query) > 0){
            while($fetch_event = mysqli_fetch_assoc($register_query)){
      ?>
      <div class="borrow-box">
         <p> Tên sự kiện : <span><?php echo $fetch_event['event_name']; ?></span> </p>
         <img width="180px" height="207px" src="uploaded_img/<?php echo $fetch_event['event_img']; ?>" alt="">
         <?php
         $event_id =$fetch_event['event_id'];
         $event_query = mysqli_query($conn, "SELECT * FROM `events` WHERE id = '$event_id'") or die('query failed');
         $fetch_info_event = mysqli_fetch_assoc($event_query)
         ?>
         <p> Địa điểm : <span><?php echo $fetch_info_event['address']; ?></span> </p>
         <p> Thời gian : 
            <span>
                <?php 
                  $date_object = DateTime::createFromFormat('Y-m-d', $fetch_info_event['time']);
                  echo $date_object->format('d-m-Y');
               ?>
            </span>  
         </p>
         <p style="margin-bottom: 10px;"> Trạng thái  : 
            <span style="color:<?php if($fetch_event['is_confirmed'] == 1){ echo 'green'; }else if($fetch_event['is_confirmed'] == '0'){ echo 'red'; }else{ echo 'orange'; } ?>;">
               <?php if ($fetch_event['is_confirmed'] == 1) {
                     echo 'Đã xác nhận';
                  } else {
                     echo 'Chờ xác nhận';
                  }
               ?>
            </span> 
         </p>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">Chưa có sự kiện nào được đăng ký!</p>';
      }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>