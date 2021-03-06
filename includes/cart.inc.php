<?php
session_start();
include "../classes/dbconnection.classes.php";
include "../Model/cartModel.php";
include "../classes/Cart.classes.php";
include "../classes/Medicine.classes.php";
include "../classes/pharmacy_medicine.classes.php";
include "../classes/Pharmacy.classes.php";
include "../classes/Pharmacy_.classes.php";
include "../Controller/controller.php";
include "../Controller/cartContr.php";
include "../View/cartView.php";

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
    if (isset($_SESSION['successDlt'])) {
        unset($_SESSION['successDlt']);
    }
}
if (isset($_POST['buyNow'])) {
    $_SESSION['pharmacyID'] = $_POST['pharmID'];
    $_SESSION['medQuantityArr'] = unserialize($_POST['medQuantityArr']);
    $_SESSION['order'] = 'buyNow';
    $_SESSION['fromCart'] = true;
    if (isset($_SESSION['successDlt'])) {
        unset($_SESSION['successDlt']);
    }
    header('Location: ../orderNow.php');
    exit();
}
if (isset($_POST['reserveNow'])) {
    $_SESSION['pharmacyID'] = $_POST['pharmID'];
    $_SESSION['medQuantityArr'] = unserialize($_POST['medQuantityArr']);
    $_SESSION['order'] = 'reserveNow';
    $_SESSION['fromCart'] = true;
    if (isset($_SESSION['successDlt'])) {
        unset($_SESSION['successDlt']);
    }
    header('Location: ../orderNow.php');
    exit();
}
header('Location: ../cart.php');
