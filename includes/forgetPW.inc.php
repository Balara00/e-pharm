<?php

if(isset($_POST["send_code"])){
    $email = $_POST["email"];

    include_once "../classes/DBConn.php";
    include_once "../Models/forgetPW.models.php";
    include_once "../Controllers/forgetPW-contr.php";

    $forgetPW = new ForgetPWContr($email);

    $forgetPW->sendMail();
}

?>
