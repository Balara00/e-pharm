<?php
session_start();
$filter = $_GET["filter"];
    //echo $pid;
if($filter == "all"){
    header("location: ../myPrescriptions.php");
}
else{
    include "../classes/dbconnection.classes.php";
    include "../Model/myPrescriptions.models.php";
    include "../View/myPrescriptions.view.php";
    $presView = new MyPrescriptionView();
    
    $presView->getFilteredData($filter); 
}
?>