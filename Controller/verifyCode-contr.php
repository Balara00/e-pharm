<?php
//session_start();

class VerifyCodeContr extends Controller{
  private $model;

  public function __construct(){
    $this->model = new VerifyCode();
  }

  public function verifyCode($email, $code){
    $result = $this->model->getVerificationCode($email);
    if($result !== $code){
      $_SESSION['error'] = 'Incorrect verification Code.';
      header("Location: ../verifyCode.php?email=".$email);
      return;
    }
    else{
      header("Location: ../resetPassword.php?email=".$email);
      return;
    }
  }
}

 ?>
