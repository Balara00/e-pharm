<?php
//session_start();
class Login{
  private $pdo;

  public function __construct(){
    $dbc = DBConn::getConnection();
    $this->pdo = $dbc->connect();
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

  // public function getUser($uid, $pwd){

    
  //   $stmt = $this->pdo->prepare('SELECT customerID, name FROM customer WHERE username = :un AND password = :pw AND verifyingStatus = "verified" ');
  //   $stmt->execute(array( ':un' => $uid, ':pw' => $pwd));
  //   $row = $stmt->fetch(PDO::FETCH_ASSOC);

  //   $stmt2 = $this->pdo->prepare('SELECT pharmacyID, name FROM pharmacy WHERE username = :un AND password = :pw AND verifyingStatus = "verified" ');
  //   $stmt2->execute(array( ':un' => $uid, ':pw' => $pwd));
  //   $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

  //   if ( $row !== false OR $row2 !== false) {
  //     // if(isset($_POST['RememberMe'])){
  //     //   setcookie ("username",$username,time()+ (10 * 365 * 24 * 60 * 60));
  //     //   setcookie ("password",$password,time()+ (10 * 365 * 24 * 60 * 60));

  //     //   //header("Location: landing.php?customerID=".$_GET['customerID']);
  //     // }
  //     // else{
  //     //   if(isset($_COOKIE["username"])){
  //     //     setcookie ("username","");
  //     //   }
  //     //   if(isset($_COOKIE["password"])){
  //     //     setcookie ("password","");
  //     //   }
  //     //   //header("Location: landing.php?customerID=".$_GET['customerID']);
  //     // }
  //     //$this->viewPickUpOrders();
  //     if($row){
  //       $_SESSION["customerID"] = $row['customerID'];
  //       $_SESSION["username"] = $uid;
  //       header("Location: ../landing.php?customerID=".$row['customerID']);
  //     }
  //     elseif($row2){
  //       $_SESSION["pharmacyID"] = $row2['pharmacyID'];
  //       $_SESSION["username"] = $uid;
  //       header("Location: ../pharmacyLanding.php?pharmacyID=".$row2['pharmacyID']);
  //     }
      
  //   }
  //   else {
  //     $_SESSION['error']  = "Incorrect username or password";
  //       header("Location: ../login.php");
  //       return;
  //   }
  // }

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

  public function sendNotifications($notification,$customerID,$pharmacyID,$dateTime){
    $stmt = $this->pdo->prepare('INSERT INTO `customer_notification`(`customerID`, `pharmacyID`, `Notification`, `dateTime`, `isRead`, `isNew`)
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
    $stmt->execute(array(array(':pharmID' => $pharmID)));

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