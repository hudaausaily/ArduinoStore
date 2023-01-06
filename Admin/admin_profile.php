<?php require_once('./connectdb.php');
require_once('./sidebar.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
   $admin_id =['admin_id'];
      $select_accounts = $conn->prepare("SELECT * FROM `admins`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="page-container">
    <div  id="container-hide">

<div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title mb-3">Profile Card</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="mx-auto d-block">
                                            <img class="rounded-circle mx-auto d-block" src="images/icon/avatar-01.jpg" alt="Card image cap">
                                            <h5 class="text-sm-center mt-2 mb-1">admin id : <span><?= $fetch_accounts['id']; ?></span></h5>
                                            <div class="card-text text-sm-center">admin name : <span><?= $fetch_accounts['name']; ?></span> </div>
                                            
                                          </div>
                                        <hr>
                                        <div class="card-text text-sm-center">
                                        <div class="flex-btn">
         <a style="margin:20px;" href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }

?>








   
</body>
</html>


<?php include('./footer.php'); ?>
    
       <!-- Jquery JS-->
       <script src="vendor/jquery-3.2.1.min.js"></script>
       <!-- Bootstrap JS-->
       <script src="vendor/bootstrap-4.1/popper.min.js"></script>
       <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
       <!-- Vendor JS       -->
       <script src="vendor/slick/slick.min.js">
       </script>
       <script src="vendor/wow/wow.min.js"></script>
       <script src="vendor/animsition/animsition.min.js"></script>
       <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
       </script>
       <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
       <script src="vendor/counter-up/jquery.counterup.min.js">
       </script>
       <script src="vendor/circle-progress/circle-progress.min.js"></script>
       <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
       <script src="vendor/chartjs/Chart.bundle.min.js"></script>
       <script src="vendor/select2/select2.min.js">
       </script>
   
       <!-- Main JS-->
       <script src="js/main.js"></script>
     
  
   </body>
   
   </html>
   <!-- end document-->
   