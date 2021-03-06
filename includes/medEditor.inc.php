<?php
session_start();

include "../classes/dbconnection.classes.php";

include "../Model/medEditor.model.php";

include "../classes/medicine.class.php";
include "../classes/pharmacy_medicine.class.php";

include "../Controller/medEditor.contr.php";
include "../View/medEditor.view.php";


if (isset($_POST['saveChanges'])) {
    // Grabbing the data
    $amount = $_POST['quantityTxt'];
    $price = number_format($_POST['medPriceTxt'], 2);
    // $uploadTime = $_POST['uploadTime'];
    $pharmacyID = $_GET['pharmacyID'];
    $medID = $_GET['medID'];



    // echo "pid ".$pharmacyID;
    // echo '<br>';
    // echo "mid ".$medID;

    date_default_timezone_set('Asia/Colombo');
    $date = date('m/d/Y h:i:s a', time());

    $med_edit_contr = new MedEditorContr();
    $med_edit_contr->saveMedChanges($amount, $price, $date);
    // unset($_POST["addToCart"]);

    if (isset($_SESSION['success'])) {
        header("Location: ../medEditor.php?pharmacyID=" . $pharmacyID . "&medID=" .$medID);
    }

}


?>