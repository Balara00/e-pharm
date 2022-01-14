<?php
require_once('../Classes/dbconnection.php');

class StoreOrderModel{

    public function searchOrderType($pharmacyID,$name,$type){
        $stmt = null;

        
        if($name == 'All'){
            $stmt = $this->connect()->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ?");
            if(!$stmt->execute([$pharmacyID,$type])){
                $stmt = null;
                header("location: ../View/storeOrders.php?type=delivery?error=stmt=searchDeliveryFailed");
                exit();
            }
        }
        else{
            if($name == 'Pending'){
                $stmt = $this->connect()->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and approveStatus LIKE ?");
    
            }elseif($name == 'Accepted'){
                $stmt = $this->connect()->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and approveStatus LIKE ?");
    
            }elseif($name == 'Cancelled'){
                $stmt = $this->connect()->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and status LIKE ?");
            }elseif($name == 'Declined'){
                $stmt = $this->connect()->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and approveStatus LIKE ?");
            }elseif($name == 'Delivered'){
                $stmt = $this->connect()->prepare("SELECT * FROM order_ WHERE pharmacyID LIKE ? and orderType LIKE ? and deliveryStatus LIKE ?");
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
        $stmt = $this->connect()->prepare("SELECT * FROM medicine WHERE medID LIKE ?");

        if(!$stmt->execute([$medID])){

            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=searchmedNamePriceFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchCustomerDetails($customerID){
        $stmt = $this->connect()->prepare("SELECT * FROM customer WHERE customerID LIKE ?");

        if(!$stmt->execute([$customerID])){

            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=searchPharmacyDetails");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public function searchOrderMeds($orderID){
        $stmt = $this->connect()->prepare("SELECT * FROM order_medicine WHERE orderID LIKE ?");

        if(!$stmt->execute([$orderID])){
            $stmt = null;
            header("Location :../View/storeOrders.php?type=delivery?error=stmt=searchOrderMeds");
            exit();
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateAStatus($status,$orderID){
        $stmt = $this->connect()->prepare("UPDATE order_ SET approveStatus=? WHERE orderID=?");

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
        $stmt = $this->connect()->prepare("UPDATE order_ SET deliveryStatus=? WHERE orderID=?");

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
    public function searchOrder($orderID){


        $stmt=$this->connect()->prepare("SELECT * FROM order_ WHERE orderID = ?");

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
        $stmt1 = $this->connect()->prepare("SELECT * FROM rating_pharmacy WHERE pharmacyID LIKE ?");
        if(!$stmt1->execute([$pharmacyID])){
            $stmt1 = null;
            header("location: ../myOrders.php?error=stmt=selectRatingFailed");
            return false;
            
        }
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        if($result == null){
            $stmt = $this->connect()->prepare("INSERT INTO rating_pharmacy(pharmacyID, totalRating, noOfReviews, averageRating) VALUES (?, ?, ?,?)");
            if(!$stmt->execute([$pharmacyID,$value,1,$value])){
                $stmt = null;
                header("location: ../myOrders.php?error=stmt=insertRatingFailed");
                return false;
                
            }
        }else{
            $totalRating = $result['totalRating'] + $value;
            $noOfReviews = $result['noOfReviews'] + 1;
            $averageRating = $totalRating/$noOfReviews;

            $stmt = $this->connect()->prepare("UPDATE rating_pharmacy SET totalRating=? ,noOfReviews=? ,averageRating=? WHERE pharmacyID=?");
            if(!$stmt->execute([$totalRating,$noOfReviews,$averageRating,$pharmacyID])){
                $stmt = null;
                header("location: ../myOrders.php?error=stmt=updateRatingFailed");
                return false;
                
            }
        }
        return true;

    }

    public function connect(){
        return DBConnection::getInstance()->connect();
    }
    
}