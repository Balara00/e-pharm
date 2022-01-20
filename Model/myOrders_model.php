<?php
require_once('../Classes/dbconnection.php');

class MyOrderModel{
    private $pdo;

    public function __construct()
    {
        $this->pdo=DBConnection::getInstance()->getPDO();
    }

    public function searchOrderType($customerID,$name,$type){
        $stmt = null;

        
        if($name == 'All'){
            $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE customerID LIKE ? and orderType LIKE ?");
            if(!$stmt->execute([$customerID,$type])){
                $stmt = null;
                header("location: ../View/myOrders.php?error=stmt=searchDeliveryFailed");
                exit();
            }
        }
        else{
            if($name == 'Pending'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE customerID LIKE ? and orderType LIKE ? and status LIKE ?");
    
            }elseif($name == 'Received'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE customerID LIKE ? and orderType LIKE ? and status LIKE ?");
    
            }elseif($name == 'Cancelled'){
                $stmt = $this->pdo->prepare("SELECT * FROM order_ WHERE customerID LIKE ? and orderType LIKE ? and status LIKE ?");
            }
            
            if(!$stmt->execute([$customerID,$type,strtolower($name)])){
                $stmt = null;
                header("location: ../View/myOrders.php?error=stmt=searchDeliveryFailed");
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
            header("Location :../View/myOrders.php?error=stmt=searchmedNamePriceFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchPharmacyDetails($pharmacyID){
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy WHERE pharmacyID LIKE ?");

        if(!$stmt->execute([$pharmacyID])){

            $stmt = null;
            header("Location :../View/myOrders.php?error=stmt=searchPharmacyDetails");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public function searchOrderMeds($orderID){
        $stmt = $this->pdo->prepare("SELECT * FROM order_medicine WHERE orderID LIKE ?");

        if(!$stmt->execute([$orderID])){
            $stmt = null;
            header("Location :../View/myOrders.php?error=stmt=searchOrderMeds");
            exit();
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateStatus($status,$orderID){
        $stmt = $this->pdo->prepare("UPDATE order_ SET status=? WHERE orderID=?");

        $result = null;
        if(!$stmt->execute([$status,$orderID])){
            $stmt = null;
            header("Location :../View/myOrders.php?error=stmt=cancelOrderFailed");
            exit();
            $result = false;
            return $result;
        }
        $result =true;
        return $result;

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

    
    
}