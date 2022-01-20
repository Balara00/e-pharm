<?php
//session_start();
class Login{
  private $pdo;

  public function __construct(){
    $dbc = DBConnection::getInstance();
    $this->pdo = $dbc->getPDO();
  }

  public function getCustomer($uid, $pwd){
    $stmt = $this->pdo->prepare('SELECT customerID, name FROM customer WHERE username = :un AND password = :pw AND verifyingStatus = "verified" ');
    $stmt->execute(array( ':un' => $uid, ':pw' => $pwd));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  public function getPharmacy($uid, $pwd){
    $stmt2 = $this->pdo->prepare('SELECT pharmacyID, name FROM pharmacy WHERE username = :un AND password = :pw AND verifyingStatus = "verified" ');
    $stmt2->execute(array( ':un' => $uid, ':pw' => $pwd));
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    return $row2;
  }

  public function viewPickUpOrders(){
    $stmt = $this->pdo->prepare('SELECT `dateTime`, orderID, customerID, pharmacyID FROM order_ WHERE orderType = "pickup" AND `status`="pending" AND approveStatus = "pending" ');
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($row);
    return $row;
  }

  public function setOrderStatus($orderID){
    $stmt = $this->pdo->prepare('UPDATE `order_` SET `approveStatus`= "cancelled", `status`= "cancelled" WHERE `orderID`=:orderID');
    $stmt->execute(array(':orderID' => $orderID));
    return;
  }

  public function setMedicineAmount($orderID, $pharmacyID){
    $stmt = $this->pdo->prepare("SELECT medID, amount FROM order_medicine WHERE orderID=:orderID");
    $stmt->execute(array(':orderID' => $orderID));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $medicine){
      $medID = $medicine["medID"];
      
      $stmt1 = $this->pdo->prepare("SELECT amount FROM pharmacy_medicine WHERE medID=:medID AND pharmacyID=:pharmacyID");
      $stmt1->execute(array(':medID' => $medID, ':pharmacyID' => $pharmacyID));
      $currentAmount = $stmt1->fetch(PDO::FETCH_ASSOC);
      $amount = $medicine["amount"] + $currentAmount['amount'];
      $stmt = $this->pdo->prepare('UPDATE `pharmacy_medicine` SET `amount`=:amount WHERE `medID`=:medID AND `pharmacyID`=:pharmacyID');
      $stmt->execute(array(':amount' => $amount, ':medID' => $medID, ':pharmacyID' => $pharmacyID));
      return;
    }
  }

  public function sendNotifications($notification,$customerID,$pharmacyID,$dateTime){
    $stmt = $this->pdo->prepare('INSERT INTO `customer_notification`(`customerID`, `pharmacyID`, `notification`, `dateTime`, `isRead`, `isNew`)
      VALUES (:cid, :pid, :note, :dateAndTime, "0", "0")');
    $stmt->execute(array(
    ':cid'=>$customerID,
    ':pid' => $pharmacyID, 
    ':note' => $notification, 
    ':dateAndTime' => $dateTime));

    $stmt = $this->pdo->prepare('INSERT INTO `pharmacy_notification`(`pharmacyID`, `notification`, `dateTime`, `notificationState`, `isNew`)
      VALUES (:pid, :note, :dateAndTime, "0", "0")');
    $stmt->execute(array(
    ':pid' => $pharmacyID, 
    ':note' => $notification, 
    ':dateAndTime' => $dateTime));
    return;
  }

  public function combineNotifications($pharmID){
    $notification = "New prescription has uploaded. Check for availability of medicines.";
    $stmt = $this->pdo->prepare("SELECT notificationID FROM pharmacy_notification WHERE pharmacyID=:pharmID AND `notification`=$notification AND isNew=1");
    $stmt->execute(array(':pharmID' => $pharmID));
    $noOfnew = count($stmt->fetchAll(PDO::FETCH_ASSOC));

    $stmt = $this->pdo->prepare("DELETE FROM pharmacy_notification WHERE pharmacyID=:pharmID AND `notification`=$notification AND isNew=1");
    $stmt->execute(array(':pharmID' => $pharmID));

    $notification = $noOfnew . ' prescriptions have uploaded. Check for availability of medicines.';
    date_default_timezone_set('Asia/Colombo');
    $date = date('m/d/Y h:i:s a', time());
    $query = "INSERT INTO pharmacy_notification (pharmacyID,notification,dateTime,notificationState,isNew) 
    VALUES(:pharmID,$notification,$date,0,1)";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(array(
        ':pharmID' => $pharmID
    ));
  }


}