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
   <title>Trang chủ</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="./css/main.css">
   <style>
      .list-cate {
         text-align: center;
         font-size: 20px;
         display: flex;
         gap: 10px;
         justify-content: center;
         border: 1px solid #ddd;
         margin: auto;
         margin-bottom: 20px;
         padding: 14px;
         width: fit-content;
         border-radius: 3px;
         box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
      }
      .list-cate a {
         border-right: 1px solid #ddd;
         padding-right: 11px;
         color: #e22121;
      }
      .list-cate a:hover {
         opacity: 0.7;
      }
      .list-cate a:last-child {
         border-right: 0;
         padding: 0;
      }
      .slideshow-container {
         position: relative;
         max-width: 800px;
         margin: 0 auto;
         overflow: hidden; /* Để ẩn phần ngoài khung hình ảnh */
      }
      .slide {
         display: none;
         animation: fade 2s ease-in-out infinite; /* Sử dụng animation để thêm hiệu ứng lướt sang */
      }
      @keyframes fade {
         0%, 100% {
            opacity: 0;
         }
         25%, 75% {
            opacity: 1;
         }
      }
      .slide img {
         width: 100%;
         height: 485px;
         border-radius: 9px;
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
      .home-banner {
         min-height: 70vh;
         background:linear-gradient(rgba(0,0,0,.1), rgba(0,0,0,.1)), url(./images/home_background.png) no-repeat;
         background-size: cover;
         background-position: center;
         display: flex;
         align-items: center;
         justify-content: center;
      }

   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home home-banner">

   <div class="content">
      <div class="slideshow-container">
         <div class="slide fade">
            <img src="./images/slide1.jpg" alt="slide 1">
         </div>
         <div class="slide fade">
            <img src="./images/slide2.jpg" alt="slide 2">
         </div>
         <div class="slide fade">
            <img src="./images/slide3.jpg" alt="slide 3">
         </div>
         <div class="slide fade">
            <img src="./images/slide4.jpg" alt="slide 3">
         </div>
      </div>
      <!-- <h3>Mỗi ngày một quyển sách.</h3>
      <p>Những quyển sách đều mang trong mình những bài học ý nghĩa, những trải nghiệm đáng giá.</p>
      <a href="about.php" class="white-btn">Khám phá thêm</a> -->
   </div>

</section>

<section class="products">

   <h1 class="title">Danh sách sự kiện sắp tới</h1>
   <div class="box-container">
      <?php
      if(isset($_GET['cate_id'])) {
         $cate_id = $_GET['cate_id'];
      } else {
         $cate_id = 6;
      }
         $select_products = mysqli_query($conn, "SELECT * FROM events") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
         <form style="height: -webkit-fill-available;" action="" method="post" class="box">
            <img width="240px" height="200px" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="book-action">
               <a href="event_detail.php?event_id=<?php echo $fetch_products['id'] ?>" class="view-book" >Xem thông tin sự kiện</a>
               <a href="register_event.php?event_id=<?php echo $fetch_products['id'] ?>" class="borrow_book" >Đăng ký tham dự</a>
            </div>
         </form>
      <?php
            }
         }else{
            echo '<p class="empty">Chưa có film để đặt!</p>';
         }
      ?>
   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Bạn có thắc mắc?</h3>
      <p>Hãy để lại những điều bạn còn thắc mắc, băn khoăn hay muốn chia sẻ thêm về những quyển truyện cho chúng mình tại đây để chúng mình có thể giải đáp giúp bạn</p>
      <a href="contact.php" class="white-btn">Liên hệ</a>
   </div>

</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
<script src="./js/slide_show.js" ></script>

</body>
</html>