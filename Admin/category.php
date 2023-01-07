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

if(isset($_POST['add_category'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $descreption = $_POST['descreption'];
    $descreption = filter_var($descreption, FILTER_SANITIZE_STRING);
    
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/'.$image_01;
 
 
    $select_category = $conn->prepare("SELECT * FROM `category` WHERE category_name = ?");
    $select_category->execute([$name]);
 
    if($select_category->rowCount() > 0){
       $message[] = 'category name already exist!';
    }else{
       echo ('test');
       $insert_category = $conn->prepare("INSERT INTO `category`(category_name, category_description, category_imge) VALUES(?,?,?)");
       $insert_category->execute([$name, $descreption, $image_01]);
 
       if($insert_category){
          if($image_size_01 > 2000000 ){
             $message[] = 'image size is too large!';
          }else{
             move_uploaded_file($image_tmp_name_01, $image_folder_01);
             $message[] = 'new category added!';
          }
 
       }
 
    }  
 
 };

 if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_category_image = $conn->prepare("SELECT * FROM `category` WHERE category_id = ?");
    $delete_category_image->execute([$delete_id]);
    $fetch_delete_image = $delete_category_image->fetch(PDO::FETCH_ASSOC);
    unlink('./uploaded_img/'.$fetch_delete_image['image_01']);
    $delete_category = $conn->prepare("DELETE FROM `category` WHERE category_id = ?");
    $delete_category->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
    $delete_wishlist->execute([$delete_id]);
    header('location:category.php');
 }

?>

<div class="page-container">
    <div  id="container-hide">
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Add New </strong>category
                                </div>
                                <div class="card-body card-block">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class=" form-control-label">category name (required)</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="text" id="text-input" name="name" required placeholder="Text" class="form-control">
                                                <small class="form-text text-muted">add your category name</small>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="textarea-input" class=" form-control-label">category Description</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <textarea name="details" id="textarea-input" rows="9" required placeholder="Description..." class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="file-multiple-input" class=" form-control-label">category image 1</label>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <input type="file" id="file-multiple-input" required name="image_01" multiple="" class="form-control-file">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <input type="submit" value="Submit" name="add_category" class="btn btn-success btn-md" onclick="hideadd()">
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
                        <button type="submit" value="add category" class="btn btn-success btn-md" onclick="showadd()">Add New category</button>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3 table-earning">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">NAME</th>
                                        <th class="text-center">IMAGE</th>
                                        <th class="text-center">doing</th>
                                        <!-- <th>DESCRIPTION</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select_category = $conn->prepare("SELECT * FROM `category`"); 
                                        $select_category->execute();
                                        if($select_category->rowCount() > 0){
                                            while($fetch_category = $select_category->fetch(PDO::FETCH_ASSOC)){ 
                                    ?>
                                    <tr class="tr-shadow">
                                        <td class="align-middle text-center"><?= $fetch_category['category_id']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_category['category_name']; ?></td>
                                        <td class="align-middle text-center">
                                            <img src="../uploaded_img/<?= $fetch_category['category_imge']; ?>" alt="" width="80px">
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <a href="update_category.php?update=<?= $fetch_category['category_id']; ?>" class="zmdi zmdi-edit text-dark"></a>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <a href="./category.php?delete=<?= $fetch_category['category_id']; ?>" class="zmdi zmdi-delete text-dark" onclick="return confirm('delete this category?');">
                                                </a>
                                                </button>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php
                                        }
                                    }else{
                                        echo '<p class="empty">no category added yet!</p>';
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
        window.location.reload('category.php')
    }
</script>

<?php include('./footer.php'); ?>