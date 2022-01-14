<?php
include "../Controller/myOrders_contr.php";


if(isset($_POST['cancel'])){
    $obj =new MyOrderContr();
    if($obj->updateOrderStatus('cancelled',$_GET['orderID']) == true){
        header("Location: ../View/myOrders.php");
    }

}