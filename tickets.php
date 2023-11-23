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
   <title>Danh sách vé đã đặt</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      .borrow-container {
         display: flex;
         gap: 10px;
         flex-wrap: wrap;
      }
      .borrow-box {
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

   <h1 class="title">Danh sách vé đã đặt của bạn</h1>

   <div class="borrow-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `tickets` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_tickets = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="borrow-box">
         <p> Tên : <span><?php echo $fetch_tickets['user_name']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_tickets['email']; ?></span> </p>
         <p> Số điện thoại : <span><?php echo $fetch_tickets['phone']; ?></span> </p>
         <p> Tên phim : <span><?php echo $fetch_tickets['film_name']; ?></span> </p>
         <img width="180px" height="207px" src="uploaded_img/<?php echo $fetch_tickets['film_img']; ?>" alt="">
         <p> Số lượng vé đặt : <span><?php echo $fetch_tickets['ticket_quantity']; ?> vé</span> </p>
         <p style="margin-bottom: 10px;"> Trạng thái  : 
            <span style="color:<?php if($fetch_tickets['is_confirmed'] == 1){ echo 'green'; }else if($fetch_tickets['is_confirmed'] == '0'){ echo 'red'; }else{ echo 'orange'; } ?>;">
               <?php if ($fetch_tickets['is_confirmed'] == 1) {
                     echo 'Đã xác nhận';
                  } else {
                     echo 'Chờ xử lý';
                  }
               ?>
            </span> 
         </p>
      <?php if($fetch_tickets['is_confirmed'] == 0) {
      ?>
         <a onclick="return confirmDelete()" class="cancel_ticket" href="cancel_ticket.php?ticket_id=<?php echo $fetch_tickets['id']  ?>">Hủy vé</a>
      <?php 
            } 
      ?>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">Chưa có vé nào được đặt!</p>';
      }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
<script>
   function confirmDelete() {
       return confirm("Bạn có chắc chắn muốn xóa vé này không?");
    }
</script>
</body>
</html>