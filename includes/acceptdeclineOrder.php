<?php
session_start();
include "../Controller/storeOrders_contr.php";


if(isset($_POST['accept'])){
    $obj = new StoreOrderContr();
    if($obj->updateApproveStatus('accepted',$_GET['orderID']) == true){
        header("Location: ../View/storeOrders.php?type=".$_GET['type']);
    }

}

if(isset($_POST['decline'])){
    $obj = new StoreOrderContr();
    if($obj->updateApproveStatus('declined',$_GET['orderID']) == true){
        header("Location: ../View/storeOrders.php)type=".$_GET['type']);
    }
}

if(isset($_POST['deliver'])){
    $obj = new StoreOrderContr();
    if($obj->updateDeliveryStatus('delivered',$_GET['orderID']) == true){
        header("Location: ../View/storeOrders.php?type=".$_GET['type']);
    }
}
