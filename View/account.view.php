<?php

class AccountView{

  private $accountModel;

  public function __construct(){
    $this->accountModel = new Account();
  }

  public function getPharmacyDetails(){
    echo "ID: ".$_SESSION["pharmacyID"];
    $results = $this->accountModel->getPharmacy($_SESSION["pharmacyID"]);
    return $results;
  }

  public function getUserDetails(){
    $results = $this->accountModel->getUser($_SESSION['customerID']);
    $customer = new Customer($results['name'], $results['address'], $results['username'], $results['contactNo']);
    return $customer;
  }

  public function getUserName(){
    $customer = $this->getUserDetails();
    return $customer->getName();
  }

  public function getUserAddress(){
    $customer = $this->getUserDetails();
    return $customer->getAddress();
  }

  public function getUserEmail(){
    $customer = $this->getUserDetails();
    return $customer->getEmail();
  }

  public function getUserContact(){
    $customer = $this->getUserDetails();
    return $customer->getContactNo();
  }
}

 ?>
