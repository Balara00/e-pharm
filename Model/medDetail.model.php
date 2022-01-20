<?php

class MedDetailModel {
    private $customerID;
    private $medID;
    private $pharmacyID;
    private $pdo;
    // private $success;

    public function __construct() {
        $this->customerID = $_GET['customerID'];
        $this->medID = $_GET['medID'];
        $this->pharmacyID =  $_GET['pharmacyID'];
        $this->pdo = DBConnection::getInstance()->getPDO();
        
    }

    public function getPharmDetails() {
        $stmt = $this->pdo -> prepare("SELECT * FROM pharmacy WHERE pharmacyID = :pharmacyID");
        $stmt -> execute(array(
            ":pharmacyID" => $this->pharmacyID,
        ));
        $pharmacyDet = $stmt -> fetch(PDO::FETCH_ASSOC);   

        if ($pharmacyDet === false) {
            $_SESSION['error'] = "Can't find pharmacy record in database table course.";
            header("Location: index.php");
        }

        $_SESSION['pharmacyName'] = $pharmacyDet['name'];
        $_SESSION['pharmacyArea'] = $pharmacyDet['area'];

        // $pharmacy = new Pharmacy($this->pharmacyID, $pharmacyDet['name'], $pharmacyDet['area']);
        // return $pharmacy;

        return $pharmacyDet;
    }

    public function getMedDetails() {
        $stmt = $this->pdo -> prepare("SELECT `name` FROM medicine WHERE medID = :medID");
        $stmt -> execute(array(":medID" => $this->medID));
        $medDet = $stmt -> fetch(PDO::FETCH_ASSOC);  

        if ($medDet === false) {
            $_SESSION['error'] = "Can't find medicine record in database table course.";
            header("Location: index.php");
        }

        // Medicine::setNamePrice($this->medID, $medDet['name'], $medDet['price']);

        // return Medicine::getAll($this->medID);
        return $medDet;
    }

    public function getPharmMedDetails() {
        $stmt = $this->pdo -> prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID = :pharmacyID AND medID = :medID");
        $stmt -> execute(array(":pharmacyID" => $this->pharmacyID, ":medID" => $this->medID));
        $pharm_medDet = $stmt -> fetch(PDO::FETCH_ASSOC); 

        if ($pharm_medDet === false) {
            $_SESSION['error'] = "Can't find data record in database table course.";
            header("Location: index.php");
        }

        // $pharm_med = new PharmacyMedicine($this->pharmacyID, $this->medID, $pharm_medDet['amount'], $pharm_medDet['medURL']);

        // return $pharm_med;

        return $pharm_medDet;
    }

    public function addToCart($amount) {
        // $this->success = FALSE;

        $stmt = $this->pdo -> prepare("SELECT * FROM `cart` WHERE customerID = :customerID AND pharmacyID = :pharmacyID  AND medID = :medID");
        $stmt -> execute(array(":customerID" => $this->customerID, ":pharmacyID" => $this->pharmacyID, ":medID" => $this->medID));
        $cartDet = $stmt -> fetch(PDO::FETCH_ASSOC);  

        if (!$cartDet === false) {
            $sql = "UPDATE `cart` SET `amount` = :amount WHERE `customerID` = :customerID AND `pharmacyID` = :pharmacyID  AND `medID` = :medID";
            $stmt = $this->pdo -> prepare($sql);
            $stmt -> execute(array(
                ':amount' => $amount + $cartDet['amount'],
                ':customerID' => $this->customerID,
                ':pharmacyID' => $this->pharmacyID,
                ':medID' => $this->medID,
            ));
                    
            $_SESSION['success'] = "Record updated";
        
            header("Location: ../medDetail.php?customerID=" . $this->customerID . "&medID=" . $this->medID . "&pharmacyID=" . $this->pharmacyID);
            return;

        } else {
            $sql = "INSERT INTO cart (customerID, medID, pharmacyID, amount) VALUES (:customerID, :medID, :pharmacyID, :amount)";
            $stmt = $this->pdo -> prepare($sql);
            $stmt -> execute(array(
                ':customerID' => $this->customerID,
                ':medID' => $this->medID, 
                ':pharmacyID' => $this->pharmacyID,
                ':amount' => $amount
            ));
            $_SESSION['success'] = "Record added";
         
            header("Location: ../medDetail.php?customerID=" . $this->customerID . "&medID=" . $this->medID . "&pharmacyID=" . $this->pharmacyID);
            return;
        }
        return;
    }

    // public function getSuccess() {
    //     $p = $this->success ? 'true' : 'false';
    //     echo 'success : '. $p . "\n";
    //     return $this->success;
    // }

    public function getCurrentOrders($pharmID)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y', time());
        $stmt = $this->pdo->prepare("SELECT orderID FROM order_ WHERE pharmacyID=:pID AND orderType=:ot AND dateTime LIKE '%{$date}%' AND approveStatus != 'declined' AND status != 'cancelled'");
        $stmt->execute(array(':pID' => $pharmID, ':ot' => 'delivery'));
        $len = count($stmt->fetchAll(PDO::FETCH_ASSOC));
        return $len;
    }
}

?>