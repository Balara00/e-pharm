<?php
//session_start();
class LoginContr extends Controller{

  private $uid;
  private $pwd;
  private $rememberMe;
  private $loginModel;
  private $customer;
  private $pharmacy;

  public function __construct($uid, $pwd, $rememberMe){
    $this->uid = $uid;
    $check = md5($pwd);
    $this->pwd = $check;
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
    //$this->loginModel->getUser($this->uid, $this->pwd);

    $customer = $this->loginModel->getCustomer($this->uid, $this->pwd);
    $pharmacy = $this->loginModel->getPharmacy($this->uid, $this->pwd);

    if ( $customer !== false OR $pharmacy !== false) {
      if(isset($_POST['RememberMe'])){
        setcookie ("username",$this->uid,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("password",$this->pwd,time()+ (10 * 365 * 24 * 60 * 60));
      }
      else{
        if(isset($_COOKIE["username"])){
          setcookie ("username","");
        }
        if(isset($_COOKIE["password"])){
          setcookie ("password","");
        }
      }
      $this->checkPickUpOrderStatus();
      // echo "remember me ".$_POST['RememberMe']."<br>";
      // echo "this uid ".$this->uid;
      // echo "cookie uid ".$_COOKIE["username"];
      

      if($customer){
        $_SESSION["customerID"] = $customer['customerID'];
        $_SESSION["username"] = $this->uid;
        header("Location: ../View/landing.php?customerID=".$customer['customerID']);
      }
      elseif($pharmacy){
        $_SESSION["pharmacyID"] = $pharmacy['pharmacyID'];
        $_SESSION["username"] = $this->uid;
        $this->setCombineNotification($pharmacy['pharmacyID']);
        header("Location: ../pharmacyLanding.php?pharmacyID=".$pharmacy['pharmacyID']);
      }
      
    }
    else {
      $_SESSION['error']  = "Incorrect username or password";
        header("Location: ../login.php");
        return;
    }

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

  public function checkPickUpOrderStatus(){
    date_default_timezone_set('Asia/Colombo');
    $currentDateTime = date('m/d/Y h:i:s a', time());
    $result = $this->loginModel->viewPickUpOrders();
    foreach($result as $order){
      // $date = substr($order['dateTime'],0,10);
      // $time = substr($order['dateTime'],11);
      $expectedDate = date('m/d/Y h:i:s a', strtotime($order['dateTime'].'+2 days'));
      if($currentDateTime>$expectedDate){
        $orderID = $order['orderID'];
        $customerID = $order['customerID'];
        $pharmacyID = $order['pharmacyID'];
        $this->loginModel->setOrderStatus($orderID);
        $this->loginModel->setMedicineAmount($orderID, $pharmacyID);
        $notification = "The pick-up order with order ID - ".$orderID." got cancelled due to exceeding two days!";
        $this->loginModel->sendNotifications($notification,$customerID,$pharmacyID,$currentDateTime);
        
      }
      

    }
  }

  public function setCombineNotification($pharmacyID){
    $this->loginModel->combineNotifications($pharmacyID);
  }
}

 ?>
