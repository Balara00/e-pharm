<?php
// session_start();

class Account{

  private $pdo;

  public function __construct(){
    $dbc = DBConnection::getInstance();
    $this->pdo = $dbc->getPDO();
  }

  public function getUser($uid){

    $stmt = $this->pdo->prepare('SELECT * FROM customer WHERE customerID = :uid');

    $stmt->execute(array( ':uid' => $uid));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public function getPharmacy($pid){
    $stmt = $this->pdo->prepare('SELECT * FROM pharmacy WHERE pharmacyID = :pid');

    $stmt->execute(array( ':pid' => $pid));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }


}


 ?>
