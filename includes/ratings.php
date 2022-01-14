<?php
session_start();
include "../Controller/myOrders_contr.php";


$customerID=$_GET['customerID'];
$pharmacyID = $_GET['pharmacyID'];

if(isset($_POST['ratingsBtn'])){
   
    $rating = $_POST['rate'];
    $obj =new MyOrderContr();
    
    if($obj->updateRating($rating, $pharmacyID ) == true){
        header("Location: ../View/myOrders.php?type=delivery");
        
    }

}
