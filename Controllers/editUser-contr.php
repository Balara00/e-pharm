<?php
//session_start();

class EditUserContr extends EditUser{
  //private $uid;
  private $name;
  private $address;
  private $email;

  public function __construct( $name, $address, $email){
    //$this->$uid = $uid;
    $this->name = $name;
    $this->address = $address;
    $this->email = $email;
  }

  public function editUserDetails(){
    $this->setUserDetails($_SESSION["customerID"], $this->name, $this->address, $this->email);
  }

  //should validate inputs
}
 ?>
