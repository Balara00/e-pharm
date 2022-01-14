<?php
session_start();
$filter = $_GET["filter"];
    //echo $pid;
if($filter == "all"){
    header("location: ../myPrescriptions.php");
}
else{
    include "../classes/DBConn.php";
    include "../Models/myPrescriptions.models.php";
    include "../View/myPrescriptions.view.php";
    $presView = new MyPrescriptionView();
    
    $presView->getFilteredData($filter); 
}
?>