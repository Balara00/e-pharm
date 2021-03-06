<?php session_start();
include "classes/dbconnection.classes.php";
include "Model/ViewPrescription.model.php";
include "View/viewPrescription.view.php";
$presView = new ViewPrescription_view();

if(isset($_GET["filter"])){
  $filter = $_GET["filter"];
}
else{
  $filter = 'all';
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/viewPrescription.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title> View Prescription</title>
  </head>
  <body>
    <div class="MiddleBg" >
      <?php 
      include "navBar_pharmacy.php"
      ?>
      <!-- <div class="NavBar">
        <h1 id="epharm">E-Pharm</h1>
        <ul class="nav justify-content-end NavBarContent">
         <li class="nav-item">
           <a class="nav-link active" href="pharmacyAccount.php">Account</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="notificationPharm.php">Notification</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="logout.php">Logout</a>
         </li>
       </ul>
     </div> -->
     <div class="stripe-menu">
          <div class="stripe"></div>
          <div class="vertical-menu">
              <a href="View/viewStore.php?pharmacyID=<?= $_SESSION['pharmacyID']?>" class="a1">Store</a>
              <a href="pharmacyAccount.php?pharmacyID=<?= $_SESSION['pharmacyID']?>" id="a2"  class="a2">Pharmacy Profile</a>  
              <a class="a4">Orders</a>
              <a class="active" href="prescriptions.php?pharmacyID=<?= $_SESSION['pharmacyID']?>" class="a5">Prescriptions</a>
          </div>
      </div>

      <!-- <a href=""> <button class="plus"></button></a> -->
      <!-- <a href="addNew.php"><img src="../assets/images/editBtn.png" class="editImg"></a> -->
      

      <div class="orderType">
          <a class = "delivery delivery-pickup" href = "View/storeOrders.php?pharmacyID=<?= $_SESSION['pharmacyID'];?>&<?= "type=delivery"?>" >Delivery</a>
          <a class = "pickup delivery-pickup" href="View/storeOrders.php?<?= "type=pickup"?>"">Pickup</a>
      </div>

         <!-- <div class="vertical-menu">
            <a href="View/viewStore.php" class="a1">Pharmacy Store</a>
            <a href="pharmacyAccount.php" class="a2">Pharmacy Profile</a>
            <a href="orders.php" class="a2">Orders</a>
            <a href="prescriptions.php" class="active" class="a3">Prescriptions</a>
         </div> -->
         <div class="LoginForm">
           <?php
           
           $prescriptions = $presView->getFilteredData($filter);
           
           if($prescriptions){
            foreach ($prescriptions as $prescription) {
              ?>
              <div class="PrescDetail">
                <div class="card-header" style="background-color: white">
                <label for="dateTime"> 
                <?php echo $prescription["dateTime"] ?></label>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Ref No: <?php echo $prescription["prescID"]  ?> 
                    <?php $presView->printApproveState($prescription) ?></h5>
                  
                  
                  <div class="ImgDiv">
                  <a href="uploads/<?php echo $prescription["prescURL"] ?>" target="_blank">
                    <img class="presImg" src="uploads/<?php echo $prescription["prescURL"]?>" alt="">
                  </a>
                  </div>
                  <div class="noteDiv">
                  <label for="title">Special Note: </label>
                  <?php echo $prescription["note"];?> <br>
                  </div>
                  <hr>
                  <div class="cardBottom">
                  <?php if($prescription['approveState'] == 'notified') {?>
                    <a href="includes/viewPrescription.inc.php?status=Available&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-success disabled" role="button" aria-pressed="true" aria-disabled="true" name="Available">Available</a>
                    <a href="sendDetails.php?status=send&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-primary disabled" role="button" aria-pressed="true"  aria-disabled="true" name="SendDetails">Send Details</a>
                    <a href="includes/viewPrescription.inc.php?status=Cancel&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-danger " role="button" aria-pressed="true" aria-disabled="false" name="Cancelled">Remove</a>  
                  <?php } elseif ($prescription['approveState'] == 'cancelled'){ ?>
                  <a href="includes/viewPrescription.inc.php?status=Available&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-success " role="button" aria-pressed="true"  name="Available">Available</a>
                  <a href="sendDetails.php?status=send&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-primary " role="button" aria-pressed="true" aria-disabled="false" name="SendDetails">Send Details</a>
                  <a href="includes/viewPrescription.inc.php?status=Cancel&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-danger disabled" role="button" aria-pressed="true" aria-disabled="true" aria-disabled="true" name="Cancelled">Remove</a>  
                  
                  <?php } else{ ?>
                  <a href="includes/viewPrescription.inc.php?status=Available&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-success " role="button" aria-pressed="true"  name="Available">Available</a>
                  <a href="sendDetails.php?status=send&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-primary " role="button" aria-pressed="true" aria-disabled="false" name="SendDetails">Send Details</a>
                  <a href="includes/viewPrescription.inc.php?status=Cancel&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-danger " role="button" aria-pressed="true" aria-disabled="false" name="Cancelled">Remove</a>  
                  
                  <?php } ?>
                  </div>
                  

                </div>
              </div>
              
             <?php
           }
          }
          else{
            $presView->printEmptyStatement($filter);
          }
             ?>


          

         </div>
         <div class="FilterArea">
           <div class="nav-link">
           <a href="prescriptions.php?filter=all">All</a>
           </div>
           <div class="nav-link">
           <a href="prescriptions.php?filter=notified">Notified</a>
           </div>
           <div class="nav-link">
           <a href="prescriptions.php?filter=cancelled">Removed</a>
           </div>
           <div class="nav-link">
           <a href="prescriptions.php?filter=pending">Pending</a>
           </div>
           <!-- <div class="nav-link">
           <a href="prescriptions.php?filter=Declined">Declined</a>
           </div> -->
         </div>
     </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
