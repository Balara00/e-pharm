<?php
//session_start();

class MyPrescription{
  private $dbc;
  private $pdo;

  public function __construct(){

    $this->dbc = DBConn::getConnection();
    $this->pdo = $this->dbc->connect();

  }



  public function getPrescriptions($uid, $filter = 'all'){
    if($filter == 'all'){
      
      $stmt = $this->pdo->prepare('SELECT * FROM prescription WHERE customerID = :uid AND prescState = 1');
      $stmt->execute(array(':uid' => $uid));
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    elseif($filter == 'removed'){
      
      $stmt = $this->pdo->prepare('SELECT * FROM prescription WHERE customerID = :uid AND prescState = 0');
      $stmt->execute(array(':uid' => $uid));
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //return $prescriptions;
    return $result;
  }

  public function deletePrescription($pid){
    //echo $pid;
    
    $stmt = $this->pdo->prepare('UPDATE prescription SET prescState = 0 WHERE prescID = :pid');
    $stmt->execute(array(':pid' => $pid));
    header("location: ../myPrescriptions.php?");
  }

  public function addPrescription($pid){
    //echo $pid;
    
    $stmt = $this->pdo->prepare('UPDATE prescription SET prescState = 1 WHERE prescID = :pid');
    $stmt->execute(array(':pid' => $pid));
    header("location: ../myPrescriptions.php?filter=removed");
  }


}

?>
