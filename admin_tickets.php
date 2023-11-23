<?php

   include 'config.php';

   session_start();

   $admin_id = $_SESSION['admin_id']; //tạo session admin

   if(!isset($admin_id)){// session không tồn tại => quay lại trang đăng nhập
      header('location:login.php');
   };
   
   // Click duyệt
   if(isset($_POST['confirmed'])) {
      $film_id = $_POST['film_id'];
      
      // Lấy thông tin sách
      $sql = "SELECT * FROM films WHERE id = $film_id";
      $result = $conn->query($sql);
      $filmItem = $result->fetch_assoc();
      $film_current_quantity = $filmItem['seat_quantity'];

      $ticket_quantity = $_POST['ticket_quantity'];
      $book_ticket_id = $_POST['book_ticket_id'];
      if($film_current_quantity >= $ticket_quantity) {
         mysqli_query($conn, "UPDATE films SET seat_quantity = seat_quantity - $ticket_quantity WHERE id = $film_id;") or die('query failed');
         mysqli_query($conn1, "UPDATE tickets SET tickets.is_confirmed = 1 WHERE tickets.id = $book_ticket_id;") or die('query failed');
         $message[] = 'Xác nhận vé thành công!';
      } else {
         $message[] = 'Số lượng vé của phim này đã hết!';
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Phiếu đặt</title>

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
   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Danh sách phiếu đặt</h1>
   <div class="box-container">
      <?php
         $select_orders = mysqli_query($conn, "SELECT * FROM `tickets`") or die('query failed');
         if(mysqli_num_rows($select_orders) > 0){
            while($fetch_tickets = mysqli_fetch_assoc($select_orders)){
      ?>
               <div style="text-align: center;" class="box">
                  <p> User id : <span><?php echo $fetch_tickets['user_id']; ?></span> </p>
                  <p> Tên : <span><?php echo $fetch_tickets['user_name']; ?></span> </p>
                  <p> Email : <span><?php echo $fetch_tickets['email']; ?></span> </p>
                  <p> Số điện thoại : <span><?php echo $fetch_tickets['phone']; ?></span> </p>
                  <p> Tên phim : <span><?php echo $fetch_tickets['film_name']; ?></span> </p>
                  <p> Số lượng vé : <span><?php echo $fetch_tickets['ticket_quantity']; ?> vé</span> </p>
                  <img width="180px" height="207px" src="uploaded_img/<?php echo $fetch_tickets['film_img']; ?>" alt="">
                  <p style="margin-top: 10px;"> Trạng thái  : 
                     <span style="color:<?php if($fetch_tickets['is_confirmed'] == 1){ echo 'green'; }else if($fetch_tickets['is_confirmed'] == '0'){ echo 'red'; }else{ echo 'orange'; } ?>;">
                        <?php if ($fetch_tickets['is_confirmed'] == 1) {
                              echo 'Đã xác nhận';
                           } else {
                              echo 'Chờ xử lý';
                           }
                        ?>
                     </span> 
                  </p>
                  <form action="" method="post">
                     <input type="hidden" name="film_id" value="<?php echo $fetch_tickets['film_id'] ?>">
                     <input type="hidden" name="ticket_quantity" value="<?php echo $fetch_tickets['ticket_quantity'] ?>">
                     <input type="hidden" name="book_ticket_id" value="<?php echo $fetch_tickets['id'] ?>">
                     <input style="background:<?php if($fetch_tickets['is_confirmed'] == 1){ echo '#12c811c7'; } else{ echo 'red'; } ?>;" class="confirm-btn" type="submit" value=" <?php if ($fetch_tickets['is_confirmed'] == 1) {echo 'Đã xác nhận'; } else { echo 'Xác nhận';}  ?>" name="confirmed" <?php if($fetch_tickets['is_confirmed'] == 1) echo 'disabled' ?> >
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