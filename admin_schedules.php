<?php

   include 'config.php';

   session_start();

   $admin_id = $_SESSION['admin_id']; //tạo session admin

   if(!isset($admin_id)){// session không tồn tại => quay lại trang đăng nhập
      header('location:login.php');
   };
   
   if(isset($_POST['confirmed'])) {
      $schedule_id = $_POST['schedule_id'];
         mysqli_query($conn1, "UPDATE schedules SET schedules.is_confirmed = 1 WHERE schedules.id = $schedule_id;") or die('query failed');
         $message[] = 'Xác nhận vé thành công!';
   }

   if(isset($_GET['delete'])){
      try {
         $delete_id = $_GET['delete'];
         mysqli_query($conn, "DELETE FROM `schedules` WHERE id = '$delete_id'") or die('query failed');
         header('location:admin_schedules.php');
      } catch( Exception) {
         $message[] = 'Không thể xóa đơn đăng ký!';
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Danh sách đăng ký</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">

   <style>
      .confirm-btn {
         margin-top: 16px;
         padding: 7px 16px;
         border-radius: 4px;
         font-size: 18px;
         color: #fff;
         cursor: pointer;
      }
      .confirm-btn:hover {
         opacity: 0.8;
      }
      .delete-btn {
         padding: 7px 20px;
         margin-left: 10px;
      }
   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Danh sách đăng ký</h1>
   <div class="box-container">
      <?php
         $select_orders = mysqli_query($conn, "SELECT * FROM `schedules`") or die('query failed');
         if(mysqli_num_rows($select_orders) > 0){
            while($fetch_schedule = mysqli_fetch_assoc($select_orders)){
      ?>
               <div style="text-align: center; height: -webkit-fill-available;" class="box">
                  <p> User id : <span><?php echo $fetch_schedule['user_id']; ?></span> </p>
                  <p> Tên : <span><?php echo $fetch_schedule['user_name']; ?></span> </p>
                  <p> Email : <span><?php echo $fetch_schedule['email']; ?></span> </p>
                  <p> Tên sự kiện : <span><?php echo $fetch_schedule['event_name']; ?></span> </p>
                  <img width="250px" height="180px" src="uploaded_img/<?php echo $fetch_schedule['event_img']; ?>" alt="">
                  <p style="margin-top: 10px;"> Trạng thái  : 
                     <span style="color:<?php if($fetch_schedule['is_confirmed'] == 1){ echo 'green'; }else if($fetch_schedule['is_confirmed'] == '0'){ echo 'red'; }else{ echo 'orange'; } ?>;">
                        <?php if ($fetch_schedule['is_confirmed'] == 1) {
                              echo 'Đã xác nhận';
                           } else {
                              echo 'Chờ xác nhận';
                           }
                        ?>
                     </span> 
                  </p>
                  <form action="" method="post">
                     <input type="hidden" name="event_id" value="<?php echo $fetch_schedule['event_id'] ?>">
                     <input type="hidden" name="schedule_id" value="<?php echo $fetch_schedule['id'] ?>">
                     <?php if($fetch_schedule['is_confirmed'] == 0) { ?>
                        <input style="background: #001dff;" class="confirm-btn" type="submit" value="Xác nhận" name="confirmed" >
                     <?php } ?>
                  <a href="admin_schedules.php?delete=<?php echo $fetch_schedule['id']; ?>" class="delete-btn" onclick="return confirm('Xóa đơn đăng ký tham dự này?');">Xóa</a>
                  </form>
               </div>
      <?php
            }
         }else{
            echo '<p class="empty">Không có đơn đặt hàng nào!</p>';
         }
      ?>
   </div>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>