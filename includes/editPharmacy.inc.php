<?php
session_start();
if(isset($_POST["saveChanges"])){
  $name = $_POST["name"];
  $address = $_POST["address"];
  $area = $_POST["area"];
  $contactNumber = $_POST["contactNumber"];
  $uid = $_SESSION['pharmacyID'];

  include_once "../classes/dbconnection.classes.php";
  include_once "../Model/editPharmacy.models.php";
  include_once "../Controller/editPharmacy-contr.php";

  $edit = new EditPharmacyContr($name, $address, $area, $contactNumber);
  $edit->editPharmacyDetails();
}
elseif(isset($_POST['cancel'])){
  header("location: ../pharmacyAccount.php");
}
 ?>