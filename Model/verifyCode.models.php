<?php
//session_start();
class VerifyCode{
  private $dbc;

  public function __construct(){
    $this->dbc = DBConnection::getInstance();
  }

  public function getVerificationCode($email){
    $stmt = $this->dbc->getPDO()->prepare("SELECT verificationCode From customer WHERE username = :xyz");
    $stmt->execute(array(':xyz' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["verificationCode"];
  }


}
 ?>
