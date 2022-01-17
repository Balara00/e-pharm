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
    include "../model/addMedModel.php";
    include "../controller/controller.php";
    include "../controller/addMedContr.php";
    $addMedContr = new AddMedContr($name, $price, $amount, $file);
    $addMedContr->addMedicine();
}
header("Location: ../addMedicine.php");
