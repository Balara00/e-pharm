<?php
require_once('../Classes/dbconnection.php');

class LandingModel{


    public function getAreas(){
        $stmt = $this->connect()->prepare("SELECT `area` FROM pharmacy");
        if(!$stmt -> execute(array())){
            $stmt = null;
            header("location: ../index.php?error=stmt=getAreasFailed");
            exit();
        }
        
        $pharmacyDet = $stmt -> fetchAll(PDO::FETCH_ASSOC);  
        return $pharmacyDet;
    }

    public function connect(){
        return DBConnection::getInstance()->connect();
    }
}