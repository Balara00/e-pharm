<?php

class Customer{
  public $name;
  public $address;
  public $email;
  public $contactNo;

  public function __construct($name, $address, $email, $contactNo){
    $this->name = $name;
    $this->address = $address;
    $this->email = $email;
    $this->contactNo = $contactNo;
  }

  public function getName(){
    return $this->name;
  }

  public function getAddress(){
    return $this->address;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getContactNo(){
    return $this->contactNo;
  }
}

 ?>
