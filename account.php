<?php

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="assets/css/account.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
     <title>E-Pharm Account</title>
   </head>
   <body class="AccountBody">
     <div class="MiddleBg" >
       <div class="NavBar">
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
      </div>
      <div class="vertical-menu">
        <a href="account.php?customerID="."$_SESSION['customerID']" class="active">My Profile</a>
        <a href="orders.php">My Orders</a>
        <a href="myPrescriptions.php">My Prescriptions</a>
      </div>
      <div class="DetailsCard" >
        <?php
        include_once "classes/DBConn.php";
        include_once "Models/account.models.php";
        include_once "classes/customer.classes.php";
        include_once "View/account.view.php";
        $accountView = new AccountView();
        ?>
        <div class="detail">
          <?php echo "Name: ".$accountView->getUserName()."\n"; ?>
        </div>
        <div class="detail">
          <?php echo "Address: ".$accountView->getUserAddress()."\n"; ?>
        </div>
        <div class="detail">
          <?php echo "Email: ".$accountView->getUserEmail()."\n"; ?>
        </div>
        <div class="edit">
          <a href="edit.php">
            <button type="button" id="editbtn" class="btn" name="editBtn">Edit</button>
          </a>
        </div>

      </div>
     </div>
   </body>
 </html>
