<style>
    #container-hide{
        display: none;
    }
</style>

<?php

require_once('./connectdb.php');
require_once('./sidebar.php');

// session_start();

// $admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:admin_login.php');
// };

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    $catname = $_POST['category'];
    $catname = filter_var($catname, FILTER_SANITIZE_STRING);
 
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;
 
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/'.$image_02;
 
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/'.$image_03;
 
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $select_products->execute([$name]);
 
    if($select_products->rowCount() > 0){
       $message[] = 'product name already exist!';
    }else{
 
       $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03, category_name) VALUES(?,?,?,?,?,?,?)");
       $insert_products->execute([$name, $details, $price, $image_01, $image_02, $image_03]);
 
       if($insert_products){
          if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
             $message[] = 'image size is too large!';
          }else{
             move_uploaded_file($image_tmp_name_01, $image_folder_01);
             move_uploaded_file($image_tmp_name_02, $image_folder_02);
             move_uploaded_file($image_tmp_name_03, $image_folder_03);
             $message[] = 'new product added!';
          }
 
       }
 
    }  
 
 };
 
 if(isset($_GET['delete'])){
 
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
    unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
    unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:product.php');
 }
 
 
 ?>

?>

<div class="page-container">
    <div  id="container-hide">
        <div class="main-content ">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Add New </strong>Product
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">product name (required)</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="text-input" name="name" required placeholder="Text" class="form-control">
                                                <small class="form-text text-muted">add your products name</small>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="email-input" class=" form-control-label">product price (required)</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="email" id="email-input" name="price" required placeholder="enter your product price" class="form-control" onkeypress="if(this.value.length == 10) return false;">
                                                <small class="help-block form-text">Please enter your product price</small>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="select" class=" form-control-label">Product Category</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <select id="select" class="form-control" required name="category">
                                                    <?php
                                                        $select_category = $conn->prepare("SELECT category_name FROM `category`");
                                                        $select_category->execute();
                                                        while ($row = $select_category->fetch(PDO::FETCH_ASSOC)) {
                                                            $array[] = $row['category_name'];
                                                        }
                                                        foreach ($array as $arr) { ?>
                                                                    <option value = "<?php print($arr); ?>"> <?php print($arr); ?></option>
                                                            <?php 
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="textarea-input" class=" form-control-label">Product Description</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <textarea name="details" id="textarea-input" rows="9" required placeholder="Description..." class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="file-multiple-input" class=" form-control-label">Product image 1</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="file" id="file-multiple-input" required name="image_01" multiple="" class="form-control-file">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="file-multiple-input" class=" form-control-label">Product image 2</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="file" id="file-multiple-input" required name="image_02" multiple="" class="form-control-file">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="file-multiple-input" class=" form-control-label">Product image 3</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="file" id="file-multiple-input" required name="image_03" multiple="" class="form-control-file">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <input type="submit" value="Submit" name="add_product" class="btn btn-success btn-md" onclick="hideadd()">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 pb-4">
                        <button type="submit" value="add product" class="btn btn-success btn-md" onclick="showadd()">Add New Product</button>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3 table-earning">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">NAME</th>
                                        <th class="text-center">PRICE</th>
                                        <th class="text-center">NEW PRICE</th>
                                        <th class="text-center">CATEGORY</th>
                                        <th class="text-center">IMAGE</th>
                                        <th class="text-center">doing</th>
                                        <!-- <th>DESCRIPTION</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select_products = $conn->prepare("SELECT * FROM `products`"); 
                                        $select_products->execute();
                                        if($select_products->rowCount() > 0){
                                            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
                                    ?>
                                    <tr class="tr-shadow">
                                        <td class="align-middle text-center"><?= $fetch_products['id']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_products['name']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_products['price']; ?></td>
                                        <td class="align-middle text-center text-danger"><?= $fetch_products['price']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_products['category_name']; ?></td>
                                        <td class="align-middle text-center">
                                            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="" width="80px">
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="zmdi zmdi-edit text-dark"></a>
                                                    <i class=""></i>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <a href="./product.php?delete=<?= $fetch_products['id']; ?>" class="zmdi zmdi-delete text-dark" onclick="return confirm('delete this product?');">
                                                </a>
                                                </button>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php
                                        }
                                    }else{
                                        echo '<p class="empty">no products added yet!</p>';
                                    }?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>

<script>
    showadd = () => {
        console.log('test')
        document.getElementById('container-hide').style.display = "block"
    }

    hideadd = () => {
        console.log('test')
        window.location.reload('product.php')
    }
</script>

<?php include('./footer.php'); ?>