<?php
//session_start();
class VerifyCode{
  private $dbc;

  public function __construct(){
    $this->dbc = DBConn::getConnection();
  }

  public function getVerificationCode($email){
    $stmt = $this->dbc->connect()->prepare("SELECT verificationCode From customer WHERE username = :xyz");
    $stmt->execute(array(':xyz' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["verificationCode"];
  }


}
 ?>
