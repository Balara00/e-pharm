<?php session_start();


if(isset($_GET["filter"])){
  $filter = $_GET["filter"];
}
else{
  $filter = 'all';
}

include "classes/dbconnection.classes.php";
include "Model/myPrescriptions.models.php";
include "View/myPrescriptions.view.php";
$presView = new MyPrescriptionView();
$prescriptions = $presView->getFilteredData($filter);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/myPrescription.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    
    <title>My Prescription</title>
  </head>
  <body>
    <div class="MiddleBg" >
      <!-- <div class="NavBar">
        <h1 id="epharm">E-Pharm</h1>
        <ul class="nav justify-content-end NavBarContent">
         <li class="nav-item">
           <a class="nav-link active" href="account.php">Account</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="cart.php">Cart</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="logout.php">Logout</a>
         </li>
       </ul>
     </div> -->
     <?php include "navBar.php"; ?>
     <!-- <div class="stripe-menu"> -->
       
         <!-- <div class="vertical-menu">
             <a href="account.php" class="a1">My Profile</a>
             <a href="myOrders.php" clas="a2">My Orders</a>
             <a href="myPrescriptions.php" class="active" class="a3">My Prescriptions</a>
         </div> -->

         <div class="sidenav">
        <!-- <div class="blueBar"></div> -->
          <a href="account.php?customerID=">My Profile</a>
            <button class="dropdown-btn" style="border:none;">My Orders 
              <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
              <a href="View/myOrders.php?<?= "type=delivery"?>">Delivery</a>
              <a href="View/myOrders.php?<?= "type=pickup"?>">Pick Up</a>
            </div>
            <a href="myPrescriptions.php" class="active">My Prescriptions</a>
          </div>
          
        <div class="LoginForm">
           <?php
           
           
           if($prescriptions){
            foreach ($prescriptions as $prescription) {
              ?>

              <div class="PrescDetail">
                <h5 class="card-title">Ref No: <?php echo $prescription["prescID"]  ?></h5>
                <div class="ImgDiv">
                  <a href="uploads/<?php echo $prescription["prescURL"] ?>" target="_blank">
                    <img class="presImg" src="uploads/<?php echo $prescription["prescURL"]?>" alt="">
                  </a>
                </div>
                <div class="noteDiv">
                <label for="title" >Special Note: </label><br>
                  <?php echo $prescription["note"] ?> <br>
                </div>
                <hr>
                <div class="cardBottom">
                  
                <label for="title">Selected Area: </label>
                <?php echo $prescription["area"] ?> <br>
                <?php echo $prescription["dateTime"] ?>
                </div>
                <div class="buttonArea">
                <?php if($prescription["prescState"] == 0) {?>
                    <a href="includes/myPrescription.inc.php?operator=restore&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-primary" name="Restore">Restore</a>
                  <?php } else {?>
                    <a href="includes/myPrescription.inc.php?operator=remove&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-danger" name="Remove">Remove</a>
                  <?php } ?>
                </div>
              </div>
            
              <!-- <div class="card">
                <div class="card-header">
                <label for="title">Selected Area: </label>
                <?php echo $prescription["area"] ?>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Ref No: <?php echo $prescription["prescID"]  ?></h5>
                  <p class="card-text">
                  <label for="title">Special Note: </label>
                  <?php echo $prescription["note"] ?> <br>
                  <a href="uploads/<?php echo $prescription["prescURL"] ?>" target="_blank">
                    <img class="presImg" src="uploads/<?php echo $prescription["prescURL"]?>" alt="">
                  </a>
                  <?php echo $prescription["dateTime"] ?>
                  </p>
                  <?php if($prescription["prescState"] == 0) {?>
                    <a href="includes/myPrescription.inc.php?operator=restore&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-primary" name="Restore">Restore</a>
                  <?php } else {?>
                    <a href="includes/myPrescription.inc.php?operator=remove&prescID=<?php echo $prescription["prescID"] ?>" class="btn btn-danger" name="Remove">Remove</a>
                  <?php } ?>
                  
                </div>
              </div> -->
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
           <a href="myPrescriptions.php?filter=all">All</a>
           </div>
           <div class="nav-link">
           <a href="myPrescriptions.php?filter=removed">Removed</a>
           </div>
         </div>
     </div>
    </div>
  </body>
</html>
