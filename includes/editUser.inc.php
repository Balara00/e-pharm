<?php
session_start();
if(isset($_POST["saveChanges"])){
  $name = $_POST["name"];
  $address = $_POST["address"];
  $contactNumber = $_POST["contactNumber"];
  $uid = $_SESSION['customerID'];

  include_once "../classes/DBConn.php";
  include_once "../Models/editUser.models.php";
  include_once "../Controllers/editUser-contr.php";

  $edit = new EditUserContr($name, $address, $contactNumber);
  $edit->editUserDetails();
}
 ?>
