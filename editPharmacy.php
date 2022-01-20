<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/editPharmacy.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>Edit Pharmacy Details</title>
</head>

<body class='EditPharmacyBody'>
    <div class="MiddleBg">
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
      <div class="editForm">
        <div class="error">
          <?php
            if(isset($_SESSION['error']) ) {
              echo('<p style="color:red;
              text-align: center;
              font-family: Ubuntu;
              position: relative;

              ">'.htmlentities($_SESSION['error'])."</p>\n");
              unset($_SESSION['error']);
            }
            ?>
            <?php
              if(isset($_SESSION['success']) ) {
                echo('<p style="color:#1b93c7;
                text-align: center;
                font-family: Ubuntu;
                position: relative;

                ">'.htmlentities($_SESSION['success'])."</p>\n");
                unset($_SESSION['success']);
              }
              ?>
        </div>
        <div class="Form">
          <form method="post" action="includes/editPharmacy.inc.php">
            <?php
            include_once "classes/dbconnection.classes.php";
            include_once "Model/account.models.php";
            //include_once "classes/customer.classes.php";
            include_once "View/account.view.php";
            $accountView = new AccountView();
            $pharmacyDetails = $accountView->getPharmacyDetails();
            ?>
            <div id="editnote" class="Label">
              Enter your new data
            </div>
            <div class="Label">
              <label for="name">Name</label>
            </div>
            <div class="TextInput">
              <input type="text" name="name"
              value="<?php echo $pharmacyDetails["name"]; ?>"
              placeholder="<?php echo "name"; ?>"
            required>
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="Label">
              <label for="address">Address</label>
            </div>
            <div class="TextInput">
              <input type="text" name="address"
              value="<?php echo  $pharmacyDetails["address"]; ?>"
              placeholder= "address"
               required>
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="Label">
              <label for="address">Area</label>
            </div>
            <div class="TextInput">
              <input type="text" name="area"
              value="<?php echo  $pharmacyDetails["area"]; ?>"
              placeholder= "area"
               required>
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="Label">
              <label for="contactNumber">Contact No: </label>
            </div>
            <div class="TextInput">
              <input type="text" name="contactNumber"
              value="<?php echo  $pharmacyDetails["contactNo"]; ?>"
              placeholder= "Contact Number"
               required>
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="Label">
              <label for="email">Email Address</label>
            </div>
            <div class="TextInput">
              <label for="email"><?php echo $pharmacyDetails["username"]; ?></label>
              <!-- <input type="text" name="email"
              value=""
               required> -->
            </div>
            <div class="WhiteSpace">
            </div>

            <div class="edit">
              <button type="submit" class="btn" name="saveChanges"> Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
</body>
</html>
