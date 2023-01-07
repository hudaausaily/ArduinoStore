<?php

require_once('./connectdb.php');
require_once('./sidebar.php');
// include '../components/connect.php';

// session_start();

// $admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:admin_login.php');
// }

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:users_accounts.php');
}
?>

<div class="page-container">
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3 table-earning">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">NAME</th>
                                        <th class="text-center">EMAIL</th>
                                        <th class="text-center">doing</th>
                                        <!-- <th>DESCRIPTION</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select_accounts = $conn->prepare("SELECT * FROM `users`");
                                        $select_accounts->execute();
                                        if($select_accounts->rowCount() > 0){
                                            while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
                                    ?>
                                    <tr class="tr-shadow">
                                        <td class="align-middle text-center"><?= $fetch_accounts['id']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_accounts['name']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_accounts['email']; ?></td>
                                        <td class="align-middle text-center">
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <a href="update_category.php?update=<?= $fetch_category['id']; ?>" class="zmdi zmdi-edit text-dark"></a>
                                                    <i class=""></i>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <a href="./category.php?delete=<?= $fetch_category['id']; ?>" class="zmdi zmdi-delete text-dark" onclick="return confirm('delete this category?');">
                                                </a>
                                                </button>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php
                                        }
                                    }else{
                                        echo '<p class="empty">no users added yet!</p>';
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


<?php include('./footer.php'); ?>