<?php

session_start();

if(isset($_POST["_continue"]) && isset($_POST["email"])){
  echo "Hi";
  $email = $_POST["email"];
  $code = $_POST["code"];


  include_once "../classes/DBConn.php";
  include_once "../Models/verifyCode.models.php";
  include_once "../Controllers/Controller.php";
  include_once "../Controllers/verifyCode-contr.php";

  $codeVerifier = new VerifyCodeContr();
  $codeVerifier->verifyCode($email, $code);

}

 ?>
