<?php
session_start();
class Login{
  private $pdo;

  public function __construct(){
    $dbc = DBConn::getConnection();
    $this->pdo = $dbc->connect();
  }

  public function getUser($uid, $pwd){

    $check = md5($pwd);
    
    $stmt = $this->pdo->prepare('SELECT customerID, name FROM customer WHERE username = :un AND password = :pw AND verifyingStatus = "verified" ');
    $stmt->execute(array( ':un' => $uid, ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt2 = $this->pdo->prepare('SELECT pharmacyID, name FROM pharmacy WHERE username = :un AND password = :pw AND verifyingStatus = "verified" ');
    $stmt2->execute(array( ':un' => $uid, ':pw' => $check));
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

  if ( $row !== false OR $row2 !== false) {
    // if(isset($_POST['RememberMe'])){
    //   setcookie ("username",$username,time()+ (10 * 365 * 24 * 60 * 60));
    //   setcookie ("password",$password,time()+ (10 * 365 * 24 * 60 * 60));

    //   //header("Location: landing.php?customerID=".$_GET['customerID']);
    // }
    // else{
    //   if(isset($_COOKIE["username"])){
    //     setcookie ("username","");
    //   }
    //   if(isset($_COOKIE["password"])){
    //     setcookie ("password","");
    //   }
    //   //header("Location: landing.php?customerID=".$_GET['customerID']);
    // }
    if($row){
      $_SESSION["customerID"] = $row['customerID'];
      $_SESSION["username"] = $uid;
      header("Location: ../landing.php?customerID=".$row['customerID']);
    }
    elseif($row2){
      $_SESSION["pharmacyID"] = $row2['pharmacyID'];
      $_SESSION["username"] = $uid;
      header("Location: ../pharmacyLanding.php?pharmacyID=".$row2['pharmacyID']);
    }
    
  }
  else {
    $_SESSION['error']  = "Incorrect username or password";
      header("Location: ../login.php");
      return;
  }
}
}