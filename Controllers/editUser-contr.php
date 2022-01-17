<?php
//session_start();

class EditUserContr extends EditUser{
  //private $uid;
  private $name;
  private $address;
  private $contactNumber;

  public function __construct( $name, $address, $contactNumber){
    //$this->$uid = $uid;
    $this->name = $name;
    $this->address = $address;
    $this->contactNumber = $contactNumber;
  }

  public function editUserDetails(){
    $this->setUserDetails($_SESSION["customerID"], $this->name, $this->address, $this->contactNumber);
  }

  //should validate inputs
}
 ?>
