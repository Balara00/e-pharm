<?php
require_once('../Classes/dbconnection.php');

class ResultsModel {
    private $pdo;

    public function __construct()
    {
        $this->pdo=DBConnection::getInstance()->getPDO();
    }

    public function searchResult($searchq){
        $stmt = $this->pdo->prepare("SELECT * FROM medicine WHERE name LIKE ? ");
        
        if(!$stmt->execute(['%'.$searchq.'%'])){
            
            $stmt = null;
            header("location: ../results.php?error=stmt=searchResultfailed");
            exit();
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public function searchPharmacy($area){
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy WHERE area LIKE ?");

        if(!$stmt->execute([$area])){
            $stmt = null;
            header("location: ../reults.php?error=stmt=searchPharmacyfailed");
            exit();
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchPharmacyMeds($pharmacyIDs, $medID){
        $array=  implode(',', $pharmacyIDs)  ;
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID IN ($array) AND medID LIKE ?");
        
        if(!$stmt->execute([$medID])){
            $stmt = null;
            header("location: ../View/results.php?error=stmt=searchPharmacyMedsfailed");
            exit();
        }
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchNotifyAvailbility($customerID, $medID, $area){
        $stmt = $this->pdo->prepare("SELECT * FROM notifyAvailability WHERE customerID LIKE ? AND medID LIKE ? AND Area LIKE ?");

        if(!$stmt->execute([$customerID, $medID,$area])){
            $stmt = null;
            header("location: ../results.php?error=stmt=searchNotifyfailed");
            exit();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function setNotifyAvailability($customerID,$medID,$area,$status){
        $stmt = $this->pdo->prepare("INSERT INTO  notifyAvailability(customerID,medID,area,status) VALUES (?, ?, ?, ?)");
        
        if(!$stmt->execute([$customerID, $medID,$area,$status])){
            $stmt = null;
            header("location: ../results.php?error=stmt=setNotifyfailed");
            return false;
        }
        return true;
    }

    public function updateNotifyAvailability($customerID,$medID,$area,$status){
        $stmt = $this->pdo->prepare("UPDATE notifyAvailability SET status=? WHERE customerID=? AND medID=? AND area=?");
        if(!$stmt->execute([$status,$customerID, $medID,$area])){
            $stmt = null;
            header("location: ../results.php?error=stmt=updateNotifyfailed");
            return false;
        }
        return true;

    }


}

