<?php
require_once('../Classes/dbconnection.php');

class ViewPharmacyModel {
    private $pdo;

    public function __construct()
    {
        $this->pdo=DBConnection::getInstance()->getPDO();
    }
    public function searchResult($searchq){
        $stmt = $this->pdo->prepare("SELECT * FROM medicine WHERE name LIKE ? ");
        
        if(!$stmt->execute(['%'.$searchq.'%'])){
            
            $stmt = null;
            header("location: ../viewPharmacy.php?error=stmt=searchResultfailed");
            exit();
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public function searchMedPharmacy($pharmacyID,$medID){
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID LIKE ? AND medID LIKE ?");

        if(!$stmt->execute([$pharmacyID,$medID])){
            
            $stmt = null;
            header("location: ../viewPharmacy.php?error=stmt=searchMedfailed");
            exit();
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchAllItems($pharmacyID){
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID LIKE ?");

        if(!$stmt->execute([$pharmacyID])){

            $stmt = null;
            header("Location :../viewPharmacy.php?error=stmt=searchAllItemsFailed");
            exit();
        }
        $result = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchmedNamePrice($medID){
        $stmt = $this->pdo->prepare("SELECT * FROM medicine WHERE medID LIKE ?");

        if(!$stmt->execute([$medID])){

            $stmt = null;
            header("Location :../viewPharmacy.php?error=stmt=searchmedNamePriceFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getRating($pharmacyID){
        $stmt = $this->pdo->prepare("SELECT * FROM rating_pharmacy WHERE pharmacyID = ?");

        if(!$stmt->execute([$pharmacyID])){
            $stmt = null;
            header("Location :../viewPharmacy.php?error=stmt=getRatingFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchPharm($pharmacyID){
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy WHERE pharmacyID = ?");

        if(!$stmt->execute([$pharmacyID])){
            $stmt = null;
            header("Location :../viewPharmacy.php?error=stmt=searchPharm");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    
}