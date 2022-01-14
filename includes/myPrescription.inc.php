<?php
session_start();
$pid = $_GET["prescID"];
    //echo $pid;
    
    include "../classes/DBConn.php";
    include "../Models/MyPrescriptions.models.php";
    include "../Controllers/Controller.php";
    include "../Controllers/myPrescription-contr.php";

    $prescContr = new MyPrescriptionContr();

    if($_GET["operator"] == 'remove'){
        $prescContr->removePrescription($pid);
    }
    elseif($_GET["operator"] == 'restore'){
        $prescContr->restorePrescription($pid);
    }


    
?>