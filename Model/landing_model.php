<?php
require_once('../Classes/dbconnection.php');

class LandingModel{
    private $pdo;

    public function __construct()
    {
        $this->pdo=DBConnection::getInstance()->getPDO();
    }
    public function getAreas(){
        $stmt = $this->pdo->prepare("SELECT `area` FROM pharmacy");
        if(!$stmt -> execute(array())){
            $stmt = null;
            header("location: ../index.php?error=stmt=getAreasFailed");
            exit();
        }
        
        $pharmacyDet = $stmt -> fetchAll(PDO::FETCH_ASSOC);  
        return $pharmacyDet;
    }

    
}