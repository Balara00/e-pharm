<?php
session_start();
include "../Controller/myOrders_contr.php";


if(isset($_POST['received'])){
    $obj = new MyOrderContr();
    if($obj->updateOrderStatus('received',$_GET['orderID']) == true){
        header("Location: ../View/ratings.php?customerID=".$_GET['customerID']."&pharmacyID=".$_GET['pharmacyID']);
    }

}