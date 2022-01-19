<?php session_start(); 

include "../Controller/myOrders_contr.php";
include "../Model/navBar.model.php"; 
include "../Controller/navBar.contr.php";
$navbarContr = new NavBarContr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/stylesMyOrders.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders <?= $_SESSION['customerID'] ?></title>
</head>
<body>
<div class="navlanding">
            <a href="landing.php?customerID=<?= $_SESSION['customerID'] ?>"><img class="imgs bask" src="../assets/icons/search.svg"></a>
            <a href="../notification.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/notification.svg"></a>
            <?php 
            $notificationNo = $navbarContr->getCustomerNotificationNo($_SESSION['customerID']);
            if ($notificationNo != 0) {

                echo '<p class="notificationNo">'.$notificationNo.'</p>';
            
            }
            ?>          
            <a href="../cart.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/cart.svg"></a>

            <a href="../account.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/user.svg"></a>
            <a href=""><button name="addPrescription" id="addPres" class="butn pres" type="submit">Add Prescription</button></a>


            <a href="../logout.php?customerID=<?=$_SESSION['customerID']?>"><button name="logOut" id="logout" class="butn log" type="submit">Logout</button></a>
            


    </div>
        <header class="epharm">E-Pharm</header>
        <header class="deli-type"><?=$_GET['type']?> Orders</header>
        <div class="stripe-menu">
            <div class="stripe"></div>
            <div class="vertical-menu">
                <a href="../account.php?customerID=" class="a1">My Profile</a>
                <a id="a2" class="active" class="a2">My Orders</a>
                <a href="../myPrescriptions.php" class="a3">My Prescriptions</a>
            </div>
        </div>

        <div class="orderType">
            <a class = "delivery delivery-pickup" href = "myOrders.php?<?= "type=delivery"?>" >Delivery</a>
            <a class = "pickup delivery-pickup" href="myOrders.php?<?= "type=pickup"?>">Pickup</a>
        </div>

        <Form class="radios" method="post" action="" >
            <label class="containerRadio">All
                <input name="select" value="All" type="radio" checked="checked">
                <span class="checkmark"></span>
                
            </label>

            <label class="containerRadio">Pending
                <input name="select" value="Pending" type="radio">
                <span class="checkmark"></span>
            </label>

            <label class="containerRadio">Received
                <input name="select" value="Received" type="radio">
                <span class="checkmark"></span>
            </label>

            <label class="containerRadio">Cancelled
                <input name="select" value="Cancelled" type="radio">
                <span class="checkmark"></span>
            </label>
            <button type="submit" class="check" name="check">select</button>
        </Form>

        <?php 
        
            $orders = new MyOrderContr();
            if(isset($_POST['select'])){
                $orders->displayRadio($_POST['select'],$_GET['type']) ;
            }else{ $orders->display('All',$_GET['type']);  } ?>


</body>
</html>