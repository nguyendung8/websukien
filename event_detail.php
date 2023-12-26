<?php

   include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id']; //tạo session người dùng thường

   if(!isset($user_id)){// session không tồn tại => quay lại trang đăng nhập
      header('location:login.php');
   }
   $event_id = $_GET['event_id'];

   $sql = "SELECT * FROM events WHERE id = $event_id";
   $result = $conn->query($sql);
   $eventItem = $result->fetch_assoc()


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Xem thông tin sự kiện</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      .view-book {
         padding: 15px;
      }
      .modal{
         width: 500px;
         margin: auto;
         border: 2px solid #eee;
         padding: 20px 41px;
         box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
         border-radius: 5px;
      }
      .modal-container{
         background-color:#fff;
         text-align: center;
      }
      .bookdetail-title {
         font-size: 21px;
         padding-top: 10px;
         color: #9e1ed4;
      }
      .bookdetail-img {
         margin-top: 18px;
         width: 230px;
      }
      .bookdetail-author {
         margin-top: 11px;
         font-size: 20px;
         margin-bottom: 25px;
      }
      .bookdetail-desc {
         margin: 20px 10px;
         font-size: 16px;
      }
      .borrow_book:hover { 
         opacity: 0.9;
      }
      .borrow_book {
         padding: 5px 25px;
         background-image: linear-gradient(to right, #ff9800, #F7695D);
         border-radius: 4px;
         cursor: pointer;
         font-size: 20px;
         color: #fff;
         font-weight: 700;
      }
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="view-book">
   <?php if ($eventItem) : ?>
         <!-- Modal View Detail Book -->
      <div class="modal">
         <div class="modal-container">
            <h3 class="bookdetail-title"><?php echo($eventItem['name']) ?></h3>
            <div>
               <img class="bookdetail-img" src="uploaded_img/<?php echo $eventItem['image']; ?>" alt="">
            </div>
            <p class="bookdetail-author">
               Địa điểm: 
               <?php echo ($eventItem['address']) ?>
            </p>
            <p class="bookdetail-author">
               Thời gian: 
               <?php 
                  $date_object = DateTime::createFromFormat('Y-m-d', $eventItem['time']);
                  echo $date_object->format('d-m-Y');
               ?>
            </p>
            <p class="bookdetail-author">
               Mô tả: 
               <?php echo ($eventItem['description']) ?>
            </p>
            <a href="register_event.php?event_id=<?php echo $eventItem['id'] ?>" class="borrow_book" >Đăng ký tham dự</a>
         </div>
      </div>
   <?php else : ?>
      <p style="font-size: 20px; text-align: center;">Không xem được chi tiết sự kiện này</p>
   <?php endif; ?>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>