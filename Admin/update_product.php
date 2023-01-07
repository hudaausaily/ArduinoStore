<style>
   .update-product form{
      background-color: var(--white);
      box-shadow: var(--box-shadow);
      border-radius: .5rem;
      border:var(--border);
      padding:2rem;
      max-width: 30rem;
      margin:0 auto;
   }

   .update-product form .image-container{
      margin-bottom: 2rem;
   }

   .update-product form .image-container .main-image img{
      height: 10rem;
      width: 100%;
      object-fit: contain;
   }

   .update-product form .image-container .sub-image img:hover{
      transform: scale(1.1);
   }

   .update-product form .box{
      width: 100%;
      border-radius: .5rem;
      padding:1.4rem;
      color:var(--black);
      background-color: var(--light-bg);
   }

   .update-product form span{
      color:var(--light-color);
   }

   .update-product form textarea{
      resize: none;
   }
</style>

<?php

require_once('./connectdb.php');
require_once('./sidebar.php');

// session_start();

// $admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:admin_login.php');
// }

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, details = ? WHERE id = ?");
   $update_product->execute([$name, $details, $pid]);

   $message[] = 'product updated successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'image 01 updated successfully!';
      }
   }

}

?>


<div class="page-container">
    <div  id="container-hide">
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">

                           <section class="update-product">

                              <?php
                                 $update_id = $_GET['update'];
                                 $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                                 $select_product->execute([$update_id]);
                                 if($select_product->rowCount() > 0){
                                    while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){ 
                              ?>
                              <form action="" method="post" enctype="multipart/form-data">
                                 <div class="card-header">
                                    <strong>update </strong>product
                                 </div>
                                 <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                                 <input type="hidden" name="old_image_01" value="<?= $fetch_product['image_01']; ?>">
                                 <div class="image-container">
                                    <div class="main-image">
                                       <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <label for="text-input" class=" form-control-label">product Name</label>
                                    <input type="text" name="name" required class="form-control" maxlength="100" placeholder="enter product name" value="<?= $fetch_product['name']; ?>">
                                 </div>
                                 <div class="row form-group">
                                    <label for="text-input" class=" form-control-label">product Description</label>
                                    <textarea name="details" class="form-control" required cols="30" rows="10"><?= $fetch_product['details']; ?></textarea>
                                 </div>
                                 <div class="row form-group">
                                    <label for="text-input" class=" form-control-label">update image</label>
                                    <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="form-control">
                                 </div>
                                 <div class="flex-btn">
                                    <input type="submit" name="update" class="btn btn-success" value="update">
                                    <a href="product.php" class="option-btn">go back</a>
                                 </div>
                              </form>
                              
                              <?php
                                    }
                                 }else{
                                    echo '<p class="empty">no product found!</p>';
                                 }
                              ?>

                           </section>
      
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   


<?php include('./footer.php'); ?>