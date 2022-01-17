<?php
session_start();
if(isset($_GET['status']) and isset($_GET['prescID'])){

    $status = $_GET['status'];
    $prescID = $_GET['prescID'];
    // echo "status: ".$status;
    // echo "prescID: ".$prescID;
    include "../classes/DBConn.php";
    include "../Model/ViewPrescription.model.php";
    include "../Controller/Controller.php";
    include "../Controller/viewPrescription-contr.php";
    $notification = 'All the medicines in your prescription (ref No: '.$prescID.') are available in our pharmacy!';
    $viewPrescContr = new ViewPrescriptionContr($status, $prescID);
    $viewPrescContr->executeStatus($notification);
    header("Location: ../prescriptions.php");
    
    
}

elseif(isset($_POST['send'])){
    $prescID = $_POST['prescID'];
    $availableMeds = nl2br(trim($_POST['availableMedicines']));
    $unavailableMeds = nl2br(trim($_POST['unavailableMedicines']));
    $specialNote = nl2br(trim($_POST['specialNote']));
    $status = 'Available';

    $notification = "Prescription ref No: <br>".$prescID."<br>"."Available Medicines: <br>".$availableMeds."<br>"."Unavailable Medicines: <br>".$unavailableMeds."<br>"
    ."Special Note: <br>".$specialNote."<br>";

    include "../classes/DBConn.php";
    include "../Model/ViewPrescription.model.php";
    include "../Controller/Controller.php";
    include "../Controller/viewPrescription-contr.php";

    $viewPrescContr = new ViewPrescriptionContr($status, $prescID);
    $viewPrescContr->executeStatus($notification);
    header("Location: ../prescriptions.php");
}