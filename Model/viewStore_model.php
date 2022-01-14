<?php
require_once('../Classes/dbconnection.php');

class ViewStoreModel {

    public function searchResult($searchq){
        $stmt = $this->connect()->prepare("SELECT * FROM medicine WHERE name LIKE ? ");
        
        if(!$stmt->execute(['%'.$searchq.'%'])){
            
            $stmt = null;
            header("location: ../View/viewStore.php?error=stmt=searchResultfailed");
            exit();
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public function searchMedPharmacy($pharmacyID,$medID){
        $stmt = $this->connect()->prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID LIKE ? AND medID LIKE ?");

        if(!$stmt->execute([$pharmacyID,$medID])){
            
            $stmt = null;
            header("location: ../View/viewStore.php?error=stmt=searchMedfailed");
            exit();
        }
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchAllItems($pharmacyID){
        $stmt = $this->connect()->prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID LIKE ?");

        if(!$stmt->execute([$pharmacyID])){

            $stmt = null;
            header("Location :../View/viewStore.php?error=stmt=searchAllItemsFailed");
            exit();
        }
        $result = $stmt->fetchALl(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchmedNamePrice($medID){
        $stmt = $this->connect()->prepare("SELECT * FROM medicine WHERE medID LIKE ?");

        if(!$stmt->execute([$medID])){

            $stmt = null;
            header("Location :../View/viewStore.php?error=stmt=searchmedNamePriceFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function selectPharm($pharmacyID){
        $stmt =$this->connect()->prepare("SELECT * FROM pharmacy WHERE pharmacyID=?");

        if(!$stmt->execute([$pharmacyID])){
            $stmt = null;
            header("Location: ../View/viewStore.php?error=stmt=selectPharmacyFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public function getRating($pharmacyID){
        $stmt = $this->connect()->prepare("SELECT * FROM rating_pharmacy WHERE pharmacyID = ?");

        if(!$stmt->execute([$pharmacyID])){
            $stmt = null;
            header("Location :../viewPharmacy.php?error=stmt=getRatingFailed");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function searchPharm($pharmacyID){
        $stmt = $this->connect()->prepare("SELECT * FROM pharmacy WHERE pharmacyID = ?");

        if(!$stmt->execute([$pharmacyID])){
            $stmt = null;
            header("Location :../viewPharmacy.php?error=stmt=searchPharm");
            exit();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }



    public function connect(){
        return DBConnection::getInstance()->connect();
    }
}