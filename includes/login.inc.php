<?php
session_start();

if(isset($_POST["login_user"])){

  $uid = $_POST['username'];
  $pwd = $_POST["password"];
  $rememberMe = $_POST['RememberMe'];

  include_once "../classes/DBConn.php";
  include_once "../Models/login.models.php";
  include_once "../Controllers/Controller.php";
  include_once "../Controllers/login-contr.php";

  $login = new LoginContr($uid, $pwd, $rememberMe);
  $login->loginUser();
}

 ?>
