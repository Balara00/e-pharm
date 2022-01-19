<?php 

class PharmacyMedicine{
    private $pharmacyID;
    private $medID;
    private $amount;
    private $medURL;

    public function __construct($pharmacyID, $medID, $amount, $medURL ){
        $this->pharmacyID =$pharmacyID;
        $this->medID = $medID;
        $this->amount = $amount;
        $this->medURL = $medURL;
    }

    public function getpharmacyID(){
        return $this->pharmacyID ;
    }
    public function getmedID(){
        return $this->medID ;
    }
    public function getamount(){
        return $this->amount ;
    }
    public function getmedURL(){
        return $this->medURL ;
    }

}

