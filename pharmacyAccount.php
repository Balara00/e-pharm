<?php
session_start();
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="assets/css/pharmacyAccount.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
     <title>E-Pharm Account</title>
   </head>
   <body>
     <div class="MiddleBg" >
       <div class="NavBar">
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
      </div>
      <div class="vertical-menu">
        <a href="store.php" class="a1">Pharmacy Store</a>
        <a href="pharmacyAccount.php" class="active" class="a2">Pharmacy Profile</a>
        <a href="orders.php" class="a3">Orders</a>
        <a href="prescriptions.php" class="a4">Prescriptions</a>
      </div>
      <div class="OuterDetailsCard">
      <div class="DetailsCard" >
        <?php
        include_once "classes/dbconnection.classes.php";
        include_once "Model/account.models.php";
        include_once "classes/customer.classes.php";
        include_once "View/account.view.php";
        $accountView = new AccountView();
        $pharmacyDetails = $accountView->getPharmacyDetails();
        ?>
        <div class="detail">
          <?php echo "Name: ".$pharmacyDetails["name"]."\n"; ?>
        </div>
        <div class="detail">
          <?php echo "Address: ".$pharmacyDetails["address"]."\n"; ?>
        </div>
        <div class="detail">
          <?php echo "Email: ".$pharmacyDetails["username"]."\n"; ?>
        </div>
        <div class="detail">
          <?php echo "Contact No: ".$pharmacyDetails["contactNo"]."\n"; ?>
        </div>
        <div class="detail">
          <?php echo "Area: ".$pharmacyDetails["area"]."\n"; ?>
        </div>
        <div class="detail">
          <?php echo "Is Delivery Service Available: ";
          if($pharmacyDetails["deliveryServiceStatus"] == 1){
            echo "YES\n";
          }
          else{
            echo "NO\n";
          }
           ?>
        </div>
        <div class="detail">
          <?php echo "No of delivery services that can handle per day: ".$pharmacyDetails["dvOrdersPerDay"]."\n"; ?>
        </div>
        <div class="edit">
          <a href="editPharmacy.php">
            <button type="button" id="editbtn" class="btn" name="editBtn">Edit</button>
          </a>
        </div>

      </div>
      </div>
      
     </div>
   </body>
 </html>
