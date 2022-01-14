<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/navBar.css">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-light navbar_ePharm sticky-top ">
        <div class="container-fluid">
            <a class="navbar-brand navbarTitle" href="index.php">E-Pharm</a>

            <?php
            
            echo '<a class="btn navbar-brand nav-link" href="landing.php?customerID=' .$_SESSION['customerID']. '"> <img src="assets/icons/search.svg" class="searchIcon iconNavBar"> </a>';

            echo '<a class="navbar-brand nav-link" href="notification.php?customerID=' .$_SESSION['customerID']. '"> <img src="assets/icons/notification.svg" class="notificationIcon iconNavBar"> </a>';

            echo '<a class="navbar-brand nav-link" href="cart.php?customerID=' .$_SESSION['customerID']. '"> <img src="assets/icons/cart.svg" class="cartIcon iconNavBar"> </a>';

            echo '<a class="navbar-brand nav-link " href="account.php?customerID=' .$_SESSION['customerID']. '"> <img src="assets/icons/user.svg" class="userIcon iconNavBar"> </a>';

            echo '<a class="btn btn-primary uploadPrescriptionBtn navBarBtn" href="uploadPrescription.php?customerID='. $_SESSION['customerID'] .'">Upload Prescription</a>';
            ?>
            
            <a class="btn btn-primary logoutBtn navBarBtn" href="logout.php">Logout</a>
        </div>
    </nav>
</body>
</html>