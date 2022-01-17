<?php
session_start();
include "../classes/dbconnection.classes.php";
include "../model/cartModel.php";
include "../classes/Cart.classes.php";
include "../classes/Medicine.classes.php";
include "../classes/pharmacy_medicine.classes.php";
include "../classes/Pharmacy.classes.php";
include "../classes/Pharmacy_.classes.php";
include "../controller/controller.php";
include "../controller/cartContr.php";
include "../view/cartView.php";

$cartContr = new CartContr();

if (isset($_POST['dlt_x'])) {
    $_SESSION['pID'] = $_POST['pharmID'];
    $_SESSION['mID'] = $_POST['medID'];
    $_SESSION['successDlt'] = "successDlt";
    header('Location: ../cart.php');
}
if (isset($_POST['saveChanges'])) {

    $cartContr->setCartAmount($_SESSION['customerID'], $_POST['pharmID'], $_POST['medID'], $_POST['quantityTxt']);
}
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'yes') {
        $cartContr->removeMed($_SESSION['customerID'], $_SESSION['pID'], $_SESSION['mID']);
    }
    unset($_SESSION['successDlt']);
}
if (isset($_POST['buyNow'])) {
    $_SESSION['pharmID'] = $_POST['pharmID'];
    $_SESSION['medQuantityArr'] = unserialize($_POST['medQuantityArr']);
    $_SESSION['buyNow'] = true;
    header('Location: ../orderNow.php');
}
if (isset($_POST['reserveNow'])) {
    $_SESSION['pharmID'] = $_POST['pharmID'];
    $_SESSION['medQuantityArr'] = unserialize($_POST['medQuantityArr']);
    $_SESSION['reserveNow'] = true;
    header('Location: ../orderNow.php');
}
header('Location: ../cart.php');
