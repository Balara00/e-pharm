<?php
session_start();

if (isset($_POST['reg_user'])) {
    // receive input values from the form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $contactNo = $_POST['contactNo'];
    $password_1 = $_POST['password_1'];
    $password_2 =  $_POST['password_2'];
    $dvOrders = $_POST['dvOrders'];

    $_SESSION['username'] = $username;
    $_SESSION['name'] = $name;
    $_SESSION['area'] = $area;
    $_SESSION['address'] = $address;
    $_SESSION['contactNo'] = $contactNo;
    $_SESSION['dvOrders'] = $dvOrders;

    if (!empty($_POST['dvStatus'])) {
        $dvStatus = 1;
        $_SESSION['dvStatus'] = '1';
    } else {
        $dvStatus = 0;
        $_SESSION['dvStatus'] = '0';
        $dvOrders = 0;
    }


    include "../classes/dbconnection.classes.php";
    include "../model/signupPharmModel.php";
    include "../controller/controller.php";
    include "../controller/signupPharmContr.php";
    include "../classes/MailSender.php";
    $signupPharm = new signupPharmContr($name, $username, $password_1, $password_2, $area, $address, $contactNo, $dvStatus, $dvOrders);
    $signupPharm->signupPharm();
}
header("Location: ../signupPharm.php");
