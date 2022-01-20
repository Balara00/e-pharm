<?php
require_once('../Classes/dbconnection.php');

class StoreOrderModel{
    private $pdo;

    public function __construct()
    {
        $this->pdo=DBConnection::getInstance()->getPDO();
    }

    public function searchOrderType($pharmacyID,$name,$type){
        $stmt = null;

        
        if($name == 'All'){
            $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ?");
            if(!$stmt->execute([$pharmacyID,$type])){
                $stmt = null;
                header("location: ../View/storeOrders.php?type=delivery?error=stmt=searchDeliveryFailed");
                exit();
            }
        }
        else{
            if($name == 'Pending'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and approveStatus LIKE ?");
    
            }elseif($name == 'Accepted'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and approveStatus LIKE ?");
    
            }elseif($name == 'Cancelled'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and status LIKE ?");
            }elseif($name == 'Declined'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and approveStatus LIKE ?");
            }elseif($name == 'Delivered'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and deliveryStatus LIKE ?");
            }
            
            if(!$stmt->execute([$pharmacyID,$type,strtolower($name)])){
                $stmt = null;
                header("location: ../View/storeOrders.php?type=delivery?error=stmt=searchDeliveryFailed");
                exit();
            }
        }
        
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }

    public function searchmedNamePrice($medID){
        $stmt = $this->pdo->prepare("SELECT * FROM medicine WHERE medID LIKE ?");

        if(!$stmt->execute([$medID])){

            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=searchmedNamePriceFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchCustomerDetails($customerID){
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE customerID LIKE ?");

        if(!$stmt->execute([$customerID])){

            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=searchPharmacyDetails");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public function searchOrderMeds($orderID){
        $stmt = $this->pdo->prepare("SELECT * FROM order_medicine WHERE orderID LIKE ?");

        if(!$stmt->execute([$orderID])){
            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=searchOrderMeds");
            exit();
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateAStatus($status,$orderID){
        $stmt = $this->pdo->prepare("UPDATE order_ SET approveStatus=? WHERE orderID=?");

        $result = null;
        if(!$stmt->execute([$status,$orderID])){
            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=cancelOrderFailed");
            exit();
            $result = false;
            return $result;
        }
        $result =true;
        return $result;

    }
    public function updateDStatus($status,$orderID){
        $stmt = $this->pdo->prepare("UPDATE order_ SET deliveryStatus=? WHERE orderID=?");

        $result = null;
        if(!$stmt->execute([$status,$orderID])){
            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=cancelOrderFailed");
            exit();
            $result = false;
            return $result;
        }
        $result =true;
        return $result;

    }

    public function reduceMedAmounts($orderID,$pharmacyID){
        $stmt1 = $this->pdo->prepare("SELECT * FROM order_medicine WHERE orderID=?");
        if(!$stmt1->execute([$orderID])){
            $stmt1 = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=reduceMedAmountsFailed");
            exit();
            
        }
        $result = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $reducedAmounts=array();
        foreach($result as $row){
            $i=0;
            // $stmt2 = $this->pdo->prepare("UPDATE pharmacy_medicine SET amount=? WHERE pharmacyID=? AND medID=?");
            $stmt2 = $this->pdo->prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID=? AND medID =?");
            if(!$stmt2->execute([$pharmacyID, $row['medID']])){
                $stmt2 = null;
                header("Location :../View/storeOrders.php?type=delivery?error=stmt=reduceMedAmountsFailed");
                exit();
                
            }
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $reducedAmount=$result2['amount']-$row['amount'];
            $reducedAmounts[$i]=$reducedAmount;
            if($result2['amount']<$row['amount']){
                return false;
            }
            $i++;
        }

        foreach($result as $row){
            $i=0;
            $stmt3 = $this->pdo->prepare("UPDATE pharmacy_medicine SET amount=? WHERE pharmacyID=? AND medID=?");
            if(!$stmt3->execute([$reducedAmounts[$i],$pharmacyID, $row['medID']])){
                $stmt3 = null;
                header("Location :../View/storeOrders.php?type=delivery?error=stmt=reduceMedAmountsFailed");
                exit();
                
            }
        }
        return true;
        
    }
    public function searchOrder($orderID){


        $stmt=$this->pdo->prepare("SELECT * FROM order_ WHERE orderID = ?");

        if(!$stmt->execute([$orderID])){
            $stmt= null;
            header("Location :../View/myOrders.php?error=stmt=searchOrderFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePharmacyRating($rating,$pharmacyID){
        $value=0;
        
        if($rating=="1"){
            $value = 1;
        }elseif($rating == "2"){
            $value = 2;
        }elseif($rating == "3"){
            $value = 3;
        }elseif($rating == "4"){
            $value = 4;
        }elseif($rating == "5"){
            $value = 5;
        }
        $stmt1 = $this->pdo->prepare("SELECT * FROM rating_pharmacy WHERE pharmacyID LIKE ?");
        if(!$stmt1->execute([$pharmacyID])){
            $stmt1 = null;
            header("location: ../myOrders.php?error=stmt=selectRatingFailed");
            return false;
            
        }
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        if($result == null){
            $stmt = $this->pdo->prepare("INSERT INTO rating_pharmacy(pharmacyID, totalRating, noOfReviews, averageRating) VALUES (?, ?, ?,?)");
            if(!$stmt->execute([$pharmacyID,$value,1,$value])){
                $stmt = null;
                header("location: ../myOrders.php?error=stmt=insertRatingFailed");
                return false;
                
            }
        }else{
            $totalRating = $result['totalRating'] + $value;
            $noOfReviews = $result['noOfReviews'] + 1;
            $averageRating = $totalRating/$noOfReviews;

            $stmt = $this->pdo->prepare("UPDATE rating_pharmacy SET totalRating=? ,noOfReviews=? ,averageRating=? WHERE pharmacyID=?");
            if(!$stmt->execute([$totalRating,$noOfReviews,$averageRating,$pharmacyID])){
                $stmt = null;
                header("location: ../myOrders.php?error=stmt=updateRatingFailed");
                return false;
                
            }
        }
        return true;

    }

    public function getCurrentOrders($pharmID) {
        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y', time());
        $stmt = $this->pdo->prepare("SELECT orderID FROM order_ WHERE pharmacyID=:pID AND orderType=:ot AND dateTime LIKE '%{$date}%' AND approveStatus=:appStatus");
        $stmt->execute(array(':pID' => $pharmID, ':ot' => 'delivery', ':appStatus' => 'accepted'));
        $len = count($stmt->fetchAll(PDO::FETCH_ASSOC));
        return $len;
    }

    public function getDelOrderNo($pharmID) {
        $stmt = $this->pdo->prepare("SELECT dvOrdersPerDay FROM pharmacy WHERE pharmacyID=:pID");
        $stmt->execute(array(':pID' => $pharmID));
        $dvOrders = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $dvOrders['dvOrdersPerDay'];
    }
    
}