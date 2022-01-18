<?php

session_start();

if(isset($_POST["_continue"]) && isset($_POST["email"])){
  echo "Hi";
  $email = $_POST["email"];
  $code = $_POST["code"];


  include_once "../classes/dbconnection.classes.php";
  include_once "../Model/verifyCode.models.php";
  include_once "../Controller/Controller.php";
  include_once "../Controller/verifyCode-contr.php";

  $codeVerifier = new VerifyCodeContr();
  $codeVerifier->verifyCode($email, $code);

}

 ?>
