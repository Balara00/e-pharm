<?php
session_start();
$pid = $_GET["prescID"];
    //echo $pid;
    
    include "../classes/DBConn.php";
    include "../Model/MyPrescriptions.models.php";
    include "../Controller/Controller.php";
    include "../Controller/myPrescription-contr.php";

    $prescContr = new MyPrescriptionContr();

    if($_GET["operator"] == 'remove'){
        $prescContr->removePrescription($pid);
    }
    elseif($_GET["operator"] == 'restore'){
        $prescContr->restorePrescription($pid);
    }


    
?>