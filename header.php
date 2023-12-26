<?php
   //nhúng vào các trang bán hàng
   if(isset($message)){//hiển thị thông báo sau khi thao tác với biến message được gán giá trị
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>';//đóng thẻ này
      }
   }
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-instagram"></a>
         </div>
         <p><a href="login.php">Đăng nhập mới</a> | <a href="register.php">Đăng ký</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div style="padding: 5px !important;" class="flex">
         <a href="home.php" class="logo">
            <img width="90px" src="./images/logo_evento.png" alt="">
         </a>

         <nav class="navbar">
            <a href="home.php">Trang chủ</a>
            <a href="contact.php">Liên hệ</a>
            <a href="schedules.php">Lịch trình</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
         </div>

         <div class="user-box">
            <p>Tên người dùng : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Đăng xuất</a>
         </div>
      </div>
   </div>

</header>