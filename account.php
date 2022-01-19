<?php
session_start();
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
     <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
     <title>E-Pharm Account</title>
   </head>
   <body class="AccountBody">
     <div class="MiddleBg" >
     <?php include "navBar.php"; ?>
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
      <!-- <div class="vertical-menu">
        <a href="account.php?customerID="."$_SESSION['customerID']" class="active">My Profile</a>
        <a href="orders.php">My Orders</a>
        <a href="myPrescriptions.php">My Prescriptions</a>
      </div> -->
      <div class="sidenav">
        <!-- <div class="blueBar"></div> -->
      <a href="account.php?customerID=" class="active">My Profile</a>
        <button class="dropdown-btn" style="border:none;">My Orders 
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="myOrders.php?<?= "type=delivery"?>">Delivery</a>
          <a href="myOrders.php?<?= "type=pickup"?>">Pick Up</a>
        </div>
        <a href="myPrescriptions.php">My Prescriptions</a>
      </div>
      <div class="OuterDetailsCard">
        <div class="DetailsCard" >
          <?php
          // session_start();
          include_once "classes/dbconnection.classes.php";
          include_once "Model/account.models.php";
          include_once "classes/customer.classes.php";
          include_once "View/account.view.php";
          $accountView = new AccountView();
          ?>
          <div class="tag">
            <label for="name"><b>Name:-</b></label>
          </div>
          <div class="detail">
            <?php echo $accountView->getUserName(); ?>
          </div>
          <div class="tag">
            <label for="address"><b>Address:-</b></label>
          </div>
          <div class="detail">
            <?php echo $accountView->getUserAddress(); ?>
          </div>
          <div class="tag">
            <label for="contact"><b>Contact No:-</b></label>
          </div>
          <div class="detail">
            <?php echo $accountView->getUserContact(); ?>
          </div>
          <div class="tag">
            <label for="email"><b>Username(email):-</b></label>
          </div>
          <div class="detail">
            <?php echo $accountView->getUserEmail(); ?>
          </div>
          <div class="edit">
            <a href="edit.php">
              <button type="button" id="editbtn" class="btn" name="editBtn">Edit</button>
            </a>
          </div>

        </div>
      </div>
     </div>
     <script>
      /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
      var dropdown = document.getElementsByClassName("dropdown-btn");
      var i;

      for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
        } else {
        dropdownContent.style.display = "block";
        }
        });
      }
      </script>
   </body>
 </html>
