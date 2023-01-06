
<?php require_once('./connectdb.php');
require_once('./sidebar.php');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
<div class="page-container">
    <div  id="container-hide">
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <!-- <div class="col-md-12 pb-4">
                        <button type="submit" value="add product" class="btn btn-success btn-md" onclick="showadd()">Add New Product</button>
                    </div> -->
                    <div class="col-md-12">
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3 table-earning">
                                <thead>
                                    <tr>
                                        
                                        <th class="text-center">NAME</th>
                                        <th class="text-center">PHONE NO.</th>
                                        <th class="text-center">EMAIL</th>
                                        <th class="text-center">MESSAGE</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select_orders = $conn->prepare("SELECT * FROM `messages`"); 
                                        $select_orders->execute();
                                        if($select_orders->rowCount() > 0){
                                            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ 
                                    ?>
                                    <tr class="tr-shadow">
                                       
                                        <td class="align-middle text-center"><?= $fetch_orders['name']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_orders['number']; ?></td>
                                        <td class="align-middle text-center"><?= $fetch_orders['email']; ?></td>
                                         <td class="align-middle text-center"><?= $fetch_orders['message']; ?></td>
                                      
                                            
                                        
                                    </tr>
                                    <?php
                                        }
                                    }else{
                                        echo '<p class="empty">no orders added yet!</p>';
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
   