<?php
session_start();

if (isset($_POST['add_med'])) {
    // receive input values from the form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $_SESSION['medname'] = $name;
    $_SESSION['price'] = $price;
    $_SESSION['amount'] = $amount;
    $file = $_FILES['uploadFile'];

    include "../classes/dbconnection.classes.php";
    include "../Model/addMedModel.php";
    include "../Controller/controller.php";
    include "../Controller/addMedContr.php";
    $addMedContr = new AddMedContr($name, $price, $amount, $file);
    $addMedContr->addMedicine();
}
if (isset($_POST['back'])) {
    header("Location: ../View/viewStore.php?pharmacyID=" . $_SESSION['pharmacyID']);
    exit();
}
header("Location: ../addMedicine.php");
