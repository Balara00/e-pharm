<?php
session_start();

include "../classes/dbconnection.classes.php";
include "../Model/pharmacy.model.php";
include "../classes/pharmacy.class.php";
include "../classes/notificationMediator.php";
include "../Model/uploadPrescription.model.php"; 
include "../Controller/uploadPrescription.contr.php";
include "../View/uploadPrescription.view.php";

if (isset($_POST['uploadPresc'])) {
    $note = $_POST['prescNote'];
    $selectedArea = $_POST['selectedArea'];
    // $uploadTime = $_POST['uploadTime'];
    $uploadFile = $_FILES['prescPhoto'];

    date_default_timezone_set('Asia/Colombo');
    $uploadTime = date('m/d/Y h:i:s a', time());

    // echo $note;
    // echo $selectedArea;
    // echo $uploadTime;
    // echo $uploadFile;
   
    $upload_presc_contr = new UploadPrescriptionContr();
    $upload_presc_contr->uploadPrescDetails($selectedArea, $uploadFile, $note, $uploadTime);

    if($_SESSION['upload']) {
        $upload_presc_contr->setPharmacyList($selectedArea);

        // $prescID = $upload_presc_contr->getPrescID();
        // echo $prescID;
    
       
        $msg = "New prescription uploaded. Check for availability of medicines.";
        $upload_presc_contr->sendNotification($uploadTime);
            
        unset($_SESSION['upload']);
        header("Location: ../uploadPrescription.php?customerID=".$_GET['customerID']);

    }
   
}