<?php
session_start();

if (isset($_GET['prescID'])){
    $prescID = $_GET['prescID'];
    // echo $prescID;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/sendDetails.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>E-Pharm Login</title>
</head>

<body class="SendDetailsBody">
    <div class="MiddleBg">
    <?php 
      include "classes/dbconnection.classes.php";
      include "navBar_pharmacy.php"
      ?>
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
          <form method="post" action="includes/viewPrescription.inc.php">
            <div id="editnote" class="Label">
              Enter details 
            </div>
            <div class="Label">
              <label for="To">To: </label>
            </div>
            <div class="TextInput">
              <label for="To"><?php echo $prescID ?></label>
              <input type="hidden" name="prescID" value="<?php echo $prescID ?>">
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="Label">
              <label for="availableMedicines">Available Medicine: </label>
            </div>
            <div class="">
                <textarea class="longInputs" id="availableMedicines" name="availableMedicines" rows="10" cols="50"></textarea>
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="Label">
              <label for="unavailableMedicines">Unavailable Medicine: </label>
            </div>
            <div class="">
                <textarea class="longInputs" id="unavailableMedicines" name="unavailableMedicines" rows="10" cols="50"></textarea>
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="Label">
              <label for="specialNote">Special Note: </label>
            </div>
            <div class="">
                <textarea class="longInputs" id="specialNote" name="specialNote" rows="10" cols="50" ></textarea>
            </div>
            <div class="WhiteSpace">
            </div>
            <div class="edit">
              <button type="submit" class="btn" name="send"> Send
              </button>
              <button type="submit" class="btn" name="cancel"> Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
</body>
</html>
