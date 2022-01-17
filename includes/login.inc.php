<?php
session_start();

if(isset($_POST["login_user"])){

  $uid = $_POST['username'];
  $pwd = $_POST["password"];
  $rememberMe = $_POST['RememberMe'];

  include_once "../classes/DBConn.php";
  include_once "../Model/login.models.php";
  include_once "../Controller/Controller.php";
  include_once "../Controller/login-contr.php";

  $login = new LoginContr($uid, $pwd, $rememberMe);
  $login->loginUser();
}

 ?>
