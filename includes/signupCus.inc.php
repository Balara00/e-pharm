<?php
session_start();

if (isset($_POST['reg_user'])) {
    // receive input values from the form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $name;
    $password_1 = $_POST['password_1'];
    $password_2 =  $_POST['password_2'];

    include "../classes/dbconnection.classes.php";
    include "../Model/signupCusModel.php";
    include "../Controller/controller.php";
    include "../Controller/signupCusContr.php";
    include "../classes/MailSender.php";
    $signupCus = new signupCusContr($name, $username, $password_1, $password_2);
    $signupCus->signupCustmr();
}
header("Location: ../signupCus.php");
