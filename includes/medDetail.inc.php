<?php
session_start();

include "../classes/dbConnection.class.php";

include "../Model/medDetail.model.php";

include "../classes/pharmacy.class.php";
include "../classes/medicine.class.php";
include "../classes/pharmacy_medicine.class.php";

include "../Controller/medDetail.contr.php";
include "../View/medDetail.view.php";


if (isset($_POST['buyNow'])) {
    $amount = $_POST['quantityTxt'];
    
    $_SESSION['order'] = "buyNow";
    $_SESSION['pharmacyID'] = $_GET['pharmacyID'];
    $_SESSION['medQuantityArr'] = array($_GET['medID']=> $amount);
    header("Location: ../orderNow.php");
}

if (isset($_POST['reserveNow'])) {
    $amount = $_POST['quantityTxt'];

    $_SESSION['order'] = "reserveNow";
    $_SESSION['pharmacyID'] = $_GET['pharmacyID'];
    $_SESSION['medQuantityArr'] = array($_GET['medID']=> $amount);
    header("Location: ../orderNow.php");
}

if (isset($_POST['addToCart'])) {
    // Grabbing the data
    $amount = $_POST['quantityTxt'];

    $med_det_contr = new MedDetailContr();
    $med_det_contr->addToCart($amount);
    // unset($_POST["addToCart"]);

}


?>