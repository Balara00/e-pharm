<?php

// include "../Controller/medDetail.contr.php";

class MedDetailView {
    private $customerID;
    private $pharmacyID;
    private $medID;
    private $med_det_contr; 

    public function __construct() {
        $this->customerID = $_GET['customerID'];
        $this->pharmacyID = $_GET['pharmacyID'];
        $this->medID = $_GET['medID'];
        
        $this->med_det_contr = new MedDetailContr();
    }

    public function getCustomerID() {
        return $this->customerID;
    }

    public function getPharmacyID() {
        return $this->pharmacyID;
    }

    public function getMedID() {
        return $this->medID;
    }

    public function getMedName() {
        return $this->med_det_contr->getMedName();
    }

    public function getPharmName() {
        return $this->med_det_contr->getPharmName();
    }

    public function getPharmArea() {
        return $this->med_det_contr->getPharmArea();
    }

    public function getMedPrice() {
        return $this->med_det_contr->getMedPrice();
    }

    public function getMedQuantity() {
        return $this->med_det_contr->getMedQuantity();
    }

    public function getMedURL() {
        return $this->med_det_contr->getMedURL();
    }

    public function getPharmDelAvailability() {
        return $this->med_det_contr->getPharmDelAvailability();
    }

    public function isExceed() {
        return $this->med_det_contr->isExceed($this->pharmacyID);
    }
}

?>
