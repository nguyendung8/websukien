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
   <title>Thông tin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Về Comic</h3>
   <p> <a href="home.php">Trang chủ</a> / Thông tin </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img height="375px" style="border-radius: 3px;" src="images/about_img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Tại sao chúng ta nên xem phim?</h3>
         <p>Xem phim giúp bạn trở nên tốt đẹp hơn.</p>
         <p>Đó có thể là những bộ phim gắn với quãng thời gain bạn muốn nhớ đến, và những cảm xúc tích cực ở thời điểm đó. Nó giúp bạn làm sống lại những cảm xúc đẹp, và là điểm chốn lý tưởng cho một thực tế mỏi mệt căng thẳng trước mắt.</p>
         <a href="contact.php" class="btn">Liên hệ</a>
      </div>

   </div>

</section>

<section class="authors">

   <h1 class="title">Thành viên của Cinema</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/author-1.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-instagram"></a>
         </div>
         <h3>Công tử phố núi</h3>
      </div>
   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>