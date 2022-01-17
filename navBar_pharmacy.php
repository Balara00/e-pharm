<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/navBar_pharmacy.css">
    <title>Document</title>
</head>
<body>
    <?php
        include "Model/navBar.model.php"; 
        include "Controller/navBar.contr.php";
        include "View/navBar.view.php";

        $_SESSION['pharmacyID'] = '1';

        $navBar_view = new NavBarView();
    ?>
    <nav class="navbar navbar-light navbar_ePharm sticky-top ">
        <div class="container-fluid">
            <a class="navbar-brand navbarTitle" href="index.php">E-Pharm</a>

            <?php
            
            echo '<a class="navbar-brand nav-link" href="notification.php?pharmacyID=' .$_SESSION['pharmacyID']. '"> <img src="assets/icons/notification.svg" class="notificationIcon iconNavBar"> </a>';

            $notificationNo = $navBar_view->getPharmacyNotificationNo($_SESSION['pharmacyID']);
            if ($notificationNo != 0) {

                echo '<p class="notificationNo">'.$notificationNo.'</p>';
            
            }

            echo '<a class="navbar-brand nav-link " href="account.php?pharmacyID=' .$_SESSION['pharmacyID']. '"> <img src="assets/icons/user.svg" class="userIcon iconNavBar"> </a>';

            ?>
            
            <a class="btn btn-primary logoutBtn navBarBtn" href="logout.php">Logout</a>
        </div>
    </nav>
</body>
</html>