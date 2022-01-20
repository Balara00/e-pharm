<?php session_start(); 
$pharmacyID = $_SESSION['pharmacyID'];

include "../Controller/storeOrders_contr.php";
include "../Model/navBar.model.php"; 
include "../Controller/navBar.contr.php";
$navbarContr = new NavBarContr();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/stylesStoreOrders.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
</head>
<body>
<div class="navlanding">
            
            <a href="../notificationPharm.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><img class="imgs bask" src="../assets/icons/notification.svg"></a>
            <?php

            $notificationNo = $navbarContr->getPharmacyNotificationNo($_SESSION['pharmacyID']);
            if ($notificationNo != 0) {

                echo '<p class="notificationNo">'.$notificationNo.'</p>';
            
            }
            ?>
            <a href="user.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><img class="imgs bask" src="../assets/icons/user.svg"></a>
            
            <a href="../logout.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><button name="logOut" id="logout" class="butn log" type="submit">Logout</button></a>
            
    </div>
        <header class="epharm">E-Pharm</header>
        <header class="deli-type"><?=$_GET['type']?> Orders</header>
        <div class="stripe-menu">
            <div class="stripe"></div>
            <div class="vertical-menu">
                <a href="viewStore.php?pharmacyID=<?= $_SESSION['pharmacyID']?>" class="a1">Store</a>
                <a href="../pharmacyAccount.php?pharmacyID=<?= $_SESSION['pharmacyID']?>" id="a2"  class="a2">Pharmacy Profile</a>  
                <a class="active" class="a4" style="block-size: 80px;">Orders</a>
                <a href="../prescriptions.php?pharmacyID=<?= $_SESSION['pharmacyID']?>" class="a5">Prescriptions</a>
            </div>
        </div>

       <!-- <a href=""> <button class="plus"></button></a> -->
        <!-- <a href="addNew.php"><img src="../assets/images/editBtn.png" class="editImg"></a> -->
        

        <div class="orderType">
            <a class = "delivery delivery-pickup" href = "storeOrders.php?pharmacyID=<?= $_SESSION['pharmacyID'];?>&<?= "type=delivery"?>" >Delivery</a>
            <a class = "pickup delivery-pickup" href="storeOrders.php?<?= "type=pickup"?>">Pickup</a>
        </div>

        <div class="orderType">
            <a class = "delivery delivery-pickup" href = "storeOrders.php?pharmacyID=<?= $pharmacyID?>&<?= "type=delivery"?>" >Delivery</a>
            <a class = "pickup delivery-pickup" href="storeOrders.php?pharmacyID=<?= $pharmacyID?>&<?= "type=pickup"?>">Pickup</a>
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

            <label class="containerRadio">Accepted
                <input name="select" value="Accepted" type="radio">
                <span class="checkmark"></span>
            </label>

            <?php 
            if($_GET['type']== "delivery"){ ?>
                <label class="containerRadio">Delivered
                <input name="select" value="Delivered" type="radio">
                <span class="checkmark"></span>
            </label>

            <?php } ?>

            <label class="containerRadio">Declined
                <input name="select" value="Declined" type="radio">
                <span class="checkmark"></span>
            </label>
            <button type="submit" class="check" name="check">select</button>
        </Form>

        <?php 
        
            $orders = new StoreOrderContr();
            if(isset($_POST['select'])){
                $orders->displayRadio($_POST['select'],$_GET['type']) ;
            }else{ $orders->display('All',$_GET['type']);  } ?>


</body>
</html>