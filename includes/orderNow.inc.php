<?php
session_start();

include "../classes/dbconnection.classes.php";

include "../Model/orderNow.model.php";

include "../classes/pharmacy.class.php";
include "../classes/medicine.class.php";
include "../classes/pharmacy_medicine.class.php";

include "../classes/order.class.php";
include "../classes/deliveryOrder.class.php";
include "../classes/pickupOrder.class.php";

include "../Controller/orderNow.contr.php";
include "../View/orderNow.view.php";

if (isset($_POST['confirmOrder'])) {
    $customerID = $_SESSION['customerID'];
    $pharmacyID = $_SESSION['pharmacyID'];
    // $date = $_POST['dateTime'];
    // $name = $_POST['cus_name'];
    $phone = $_POST['phone'];
    $price = $_POST['tot'];
    $contactNo = $_POST['phone'];
    
    $orderNow_contr = new OrderNowContr();

    date_default_timezone_set('Asia/Colombo');
    $date = date('m/d/Y h:i:s a', time());
    // echo $date;
    if ($_FILES['prescPhoto']['name'] == "") {
        $prescURL = "";
    }
    else {
        $uploadFile = $_FILES['prescPhoto'];
        $prescURL = $orderNow_contr->getPrescURL($uploadFile);
    }

    if (isset($_SESSION['order']) && isset($_POST['address']) && $_SESSION['order'] == "buyNow") {
        $address = $_POST['address'];
        $orderNow_contr->setDeliveryOrderObj($customerID, $pharmacyID, $price, $date, $prescURL, $address, $contactNo);
       
    }

    if (isset($_SESSION['order']) && $_SESSION['order'] == "reserveNow") {
        $orderNow_contr->setPickUpOrderObj($customerID, $pharmacyID, $price, $date, $prescURL, $contactNo);
      
    }

    $orderNow_contr->orderNow();

    $orderNow_contr->setOrderCustomer();

    $orderNow_contr->setOrderMedicine();

    $orderNow_contr->sendNotification($pharmacyID, $date);

    header("Location: ../orderNow.php");

}