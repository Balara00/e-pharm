<?php session_start(); 
$pharmacyID = 1005;
$_SESSION['pharmacyID']=$pharmacyID;
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
            
            <a href="notification.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><img class="imgs bask" src="../assets/icons/notification.svg"></a>
            
            <a href="user.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><img class="imgs bask" src="../assets/icons/user.svg"></a>
            
            <a href="logout.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><button name="logOut" id="logout" class="butn log" type="submit">Logout</button></a>
            
    </div>
        <header class="epharm">E-Pharm</header>
        <header class="deli-type"><?=$_GET['type']?> Orders</header>
        <div class="stripe-menu">
            <div class="stripe"></div>
            <div class="vertical-menu">
                <a  href="viewStore.php" class="a1">Store</a>
                <a id="a2"  class="a2">Pharmacy Profile</a>
                <a href="myPrescriptions.php" class="a3">My Prescriptions</a>
                <a class="a4 active">Orders</a>
                <a href="" class="a5">Prescriptions</a>
            </div>
        </div>

        <div class="orderType">
            <a class = "delivery delivery-pickup" href = "storeOrders.php?pharmacyID=<?= $pharmacyID?>&<?= "type=delivery"?>" >Delivery</a>
            <a class = "pickup delivery-pickup" href="storeOrders.php?pharmacyID=<?= $pharmacyID?>&<?= "type=pickup"?>"">Pickup</a>
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

            <label class="containerRadio">Delivered
                <input name="select" value="Delivered" type="radio">
                <span class="checkmark"></span>
            </label>
            <label class="containerRadio">Declined
                <input name="select" value="Declined" type="radio">
                <span class="checkmark"></span>
            </label>
            <button type="submit" class="check" name="check">select</button>
        </Form>

        <?php 
        include "../Controller/storeOrders_contr.php";
            $orders = new StoreOrderContr();
            if(isset($_POST['select'])){
                $orders->displayRadio($_POST['select'],$_GET['type']) ;
            }else{ $orders->display('All',$_GET['type']);  } ?>


</body>
</html>