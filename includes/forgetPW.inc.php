<?php

if(isset($_POST["send_code"])){
    $email = $_POST["email"];

    include_once "../classes/dbconnection.classes.php";
    include_once "../Model/forgetPW.models.php";
    include_once "../Controller/forgetPW-contr.php";

    $forgetPW = new ForgetPWContr($email);

    $forgetPW->sendMail();
}

?>
