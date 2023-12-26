<?php

   include 'config.php';

   session_start();

   $admin_id = $_SESSION['admin_id']; //tạo session admin

   if(!isset($admin_id)){// session không tồn tại => quay lại trang đăng nhập
      header('location:login.php');
   }

   if(isset($_POST['add_product'])){//thêm sự kiện mới từ submit form name='add_product'

      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $address = mysqli_real_escape_string($conn, $_POST['address']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $time = $_POST['time'];
      $image = $_FILES['image']['name'];
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img/'.$image;

      $select_product_name = mysqli_query($conn, "SELECT name FROM `events` WHERE name = '$name'") or die('query failed');//truy vấn kiểm tra sự kiện đã tồn tại chưa

      if(mysqli_num_rows($select_product_name) > 0){
         $message[] = 'Sự kiện đã tồn tại.';
      }else{//chưa thì thêm mới
         $add_product_query = mysqli_query($conn, "INSERT INTO `events`(name, description, address, time, image) VALUES('$name', '$description', '$address', '$time', '$image')") or die('query failed');
         if($add_product_query){
            if($image_size > 2000000){//kiểm tra kích thước ảnh
               $message[] = 'Kích tước ảnh quá lớn, hãy cập nhật lại ảnh!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);//lưu file ảnh xuống
               $message[] = 'Thêm sự kiện thành công!';
            }
         }else{
            $message[] = 'Thêm sự kiện không thành công!';
         }
      }
   }

   if(isset($_GET['delete'])){//xóa sự kiện từ onclick <a></a> href='delete'
      $delete_id = $_GET['delete'];
      $delete_image_query = mysqli_query($conn, "SELECT image FROM `events` WHERE id = '$delete_id'") or die('query failed');
      $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
      unlink('uploaded_img/'.$fetch_delete_image['image']);//xóa file ảnh của sự kiện cần xóa
      mysqli_query($conn, "DELETE FROM `events` WHERE id = '$delete_id'") or die('query failed');
      header('location:admin_products.php');
   }

   if(isset($_POST['update_product'])){//cập nhật sự kiện từ form submit name='update_product'

      $update_e_id = $_POST['update_e_id'];
      $update_name = $_POST['update_name'];
      $update_desc = $_POST['update_desc'];
      $update_address = $_POST['update_address'];
      $update_time = $_POST['update_time'];

      mysqli_query($conn, "UPDATE `events` SET name = '$update_name', description = '$update_desc', address='$update_address', time='$update_time' WHERE id = '$update_e_id'") or die('query failed');

      header('location:admin_products.php');

   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sự kiện</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">

   <h1 class="title">Sự kiện</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Thêm sự kiện</h3>
      <input type="text" name="name" class="box" placeholder="Tên sự kiện" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
      <textarea type="text" name="description" class="box" placeholder="Mô tả" required></textarea>
      <input type="text" name="address" class="box" placeholder="Địa điểm" required>
      <input type="date" name="time" class="box" placeholder="Thời gian" required>
      <input type="submit" value="Thêm" name="add_product" class="btn">
   </form>

</section>

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `events`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
               <div style="height: -webkit-fill-available;" class="box">
                  <img width="200px" height="200px" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_products['name']; ?></div>
                  <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Cập nhật</a>
                  <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Xóa sự kiện này?');">Xóa</a>
               </div>
      <?php
            }
      }else{
         echo '<p class="empty">Không có sự kiện nào được thêm!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){//hiện form update từ onclick <a></a> href='update'
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `events` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
               <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="update_e_id" value="<?php echo $fetch_update['id']; ?>">
                  <img width="250px" src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                  <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Tên sự kiện">
                  <textarea type="text" name="update_desc" class="box" required placeholder="Mô tả"><?php echo $fetch_update['description']; ?></textarea>
                  <input type="text" name="update_address" value="<?php echo $fetch_update['address']; ?>" class="box" required placeholder="Địa điểm">
                  <input type="date" name="update_time" value="<?php echo $fetch_update['time']; ?>" class="box" required placeholder="Thời gian">
                  <input type="submit" value="update" name="update_product" class="btn">
                  <input type="reset" value="cancel" id="close-update" class="option-btn">
               </form>
   <?php
            }
         }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>