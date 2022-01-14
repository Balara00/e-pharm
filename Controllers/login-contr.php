<?php
session_start();
class LoginContr extends Controller{

  private $uid;
  private $pwd;
  private $rememberMe;
  private $loginModel;
  private $customer;
  private $pharmacy;

  public function __construct($uid, $pwd, $rememberMe){
    $this->uid = $uid;
    $this->pwd = $pwd;
    $this->rememberMe = $rememberMe;
    $this->loginModel = new Login();
  }

  public function loginUser(){
    if($this->emptyInput() == false){
      $_SESSION['error'] = "Username and password are required";
      header("location: ../login.php?error=emptyinput");
      exit();
    }

    //$this->loginModel->getCustomer($this->uid, $this->pwd);
    $this->loginModel->getUser($this->uid, $this->pwd);

    // $_SESSION['error'] = "Invalid Username or Password";
    // header("location: ../login.php?error=usernotfound");
    // exit();

    // $this->customer == $this->loginModel->getCustomer($this->uid, $this->pwd);
    // $this->pharmacy == $this->loginModel->getPharmacy($this->uid, $this->pwd);
    
    // if(!$this->customer and !$this->pharmacy){
    //   $_SESSION['error'] = "Invalid Username or Password";
    //   header("location: ../login.php?error=usernotfound");
    //   exit();
    // }
    // if($this->customer and $this->pharmacy){
    //   $_SESSION['error'] = "Something wrong!";
    //   header("location: ../login.php?error=somethingwrong");
    //   exit();
    // }
    // if($this->customer){
    //   $_SESSION["customerID"] = $this->customer['customerID'];
    //   $_SESSION["username"] = $this->uid;
    //   header("Location: ../landing.php?customerID=".$row['customerID']);
    //   exit();
    // }
    // if($this->pharmacy){
    //   $_SESSION["pharmacyID"] = $this->pharmacy['pharmacyID'];
    //   $_SESSION["username"] = $this->uid;
    //   header("Location: ../landing.php?customerID=".$row['customerID']);
    //   exit();
    // }
  }

  public function emptyInput(){
    $result;
    if(empty($this->uid)||empty($this->pwd)){
      $result = false;
    }
    else{
      $result = true;
    }
    return $result;
  }
}

 ?>
