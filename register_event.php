<?php

   include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id']; //tạo session người dùng thường

   if(!isset($user_id)){// session không tồn tại => quay lại trang đăng nhập
      header('location:login.php');
   }
   $film_id = $_GET['film_id'];

   // Lấy ra thông tin sách
   $sql = "SELECT * FROM films WHERE id = $film_id";
   $result = $conn->query($sql);
   $filmItem = $result->fetch_assoc();

   // Lấy ra thông tin user
   $sql1 = "SELECT * FROM users WHERE id = $user_id";
   $result1 = $conn->query($sql1);
   $user = $result1->fetch_assoc();

   // Lúc click vào nút mượn
   if(isset($_POST['submit'])) {
      $userName = $user['name'];
      $userId = $user_id;
      $film_name = $filmItem['name'];
      $film_img = $filmItem['image'];
      $ticket_quantity = $_POST['quantity'];
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $phone = mysqli_real_escape_string($conn, $_POST['phone']);

      mysqli_query($conn, "INSERT INTO `tickets`(user_id, film_id, film_name, ticket_quantity, film_img, user_name, email, phone) VALUES('$userId', '$film_id', '$film_name','$ticket_quantity', '$film_img', '$userName', '$email', '$phone')") or die('query failed');
      $message[] = 'Đặt vé thành công!';
      // header('location:home.php');
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đặt vé</title>

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
         padding-bottom: 27px;
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
         width: 180px;
      }
      .bookdetail-author {
         margin-top: 19px;
         font-size: 20px;
      }
      .bookdetail-desc {
         margin-top: 20px;
         font-size: 16px;
      }
      .form-item {
         display: flex;
         align-items: center;
         justify-content: space-evenly;
         padding: 0 15px;
      }
      .form-item span {
         font-size: 18px;
         flex: 0.5;
      }
      .form-item input {
         border: 1px solid #eee !important;
         padding: 7px 18px;
         margin-top: 4px;
         flex: 1;
         font-size: 15px;
      }
      .book_ticket_input {
         display: flex;
         flex-direction: column;
         align-items: center;
      }
      .borrow-btn {
         margin-top: 21px;
         padding: 8px;
         border-radius: 4px;
         background: #1ed224;
         color: #fff;
         font-size: 20px;
         cursor: pointer;
      }
      .borrow-btn:hover {
         opacity: 0.8;
      }
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="view-book">
   <?php if ($filmItem) : ?>
         <!-- Modal View Detail Book -->
      <form class="modal" method="post">
         <div class="modal-container">
            <h3 class="bookdetail-title">Đặt vé <?php echo($filmItem['name']) ?></h3>
            <div>
               <img class="bookdetail-img" src="uploaded_img/<?php echo $filmItem['image']; ?>" alt="">
            </div>
            <p class="bookdetail-author">
               Thời lượng: 
               <?php echo ($filmItem['show_time']) ?>
            </p>
            <p class="bookdetail-author">
               Đạo diễn: 
               <?php echo ($filmItem['director']) ?>
            </p>
            <p class="bookdetail-author">
               Diễn viên: 
               <?php echo ($filmItem['performer']) ?>
            </p>
            <p class="bookdetail-author">
               Số lượng vé còn lại: 
               <?php echo ($filmItem['seat_quantity']) ?> vé
            </p>
               <div class="form-item">
                  <span for="">Số lượng vé đặt: </span>
                  <input type="number" max="<?php echo $filmItem['seat_quantity']; ?>" min="<?=($filmItem['seat_quantity']>0) ? 1:0 ?>" name="quantity" placeholder="Nhập số lượng vé" required>
               </div>
               <div class="form-item">
                  <span for="">Email: </span>
                  <input type="email" name="email" id="" placeholder="Nhập email" required>
               </div>
               <div class="form-item">
                  <span for="">Số điện thoại: </span>
                  <input type="text" min="10" max="10" name="phone" id="" placeholder="Nhập số điện thoại" required>
               </div>
            <input class="borrow-btn" name="submit" type="submit" value="Đặt vé">
         </div>
      </form>
   <?php else : ?>
      <p style="font-size: 20px; text-align: center;">Không xem được phim này</p>
   <?php endif; ?>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>