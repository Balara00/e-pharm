<?php
session_start();

if (isset($_POST["verify_email"])) {
    $username = $_POST["username"];
    $verificationCode = $_POST["verificationCode"];
    $type = $_SESSION['type'];
    include "../classes/dbconnection.classes.php";
    include "../Model/verifyMailModel.php";
    include "../Controller/controller.php";
    include "../Controller/verifyMailContr.php";
    $mailVerify = new MailVerifyContr($username, $verificationCode, $type);
    $mailVerify->verify();
    header("Location: ../verifyMail.php?username=" . $username);
}
