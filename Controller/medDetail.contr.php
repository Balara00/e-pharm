<?php
// include "../Model/medDetail.model.php";

class MedDetailContr {
    private $medID;
    private $pharmacyID;

    private $med_det_model;
    private $pharmacy;
    private $medicine;
    private $pharmacy_medicine;

    public function __construct() {
        $this->med_det_model = new MedDetailModel();

        $this->medID = $_GET['medID'];
        $this->pharmacyID =  $_GET['pharmacyID'];

        $this->setMedObj( $this->med_det_model->getMedDetails() );
        $this->setPharmObj( $this->med_det_model->getPharmDetails() );
        $this->setPharmMedObj( $this->med_det_model->getPharmMedDetails() );
    }

    public function setMedObj($medicine_det) {
        Medicine::setName_($this->medID, $medicine_det['name']);
        $this->medicine = Medicine::getAll($this->medID);
    }

    public function setPharmObj($pharmacy_det) {
        $this->pharmacy = new Pharmacy($this->pharmacyID, $pharmacy_det['name'], $pharmacy_det['area'], $pharmacy_det['deliveryServiceStatus']);
    }

    public function setPharmMedObj($pharmacy_medicine_det) {
        $this->pharmacy_medicine = new PharmacyMedicine($this->pharmacyID, $this->medID, $pharmacy_medicine_det['amount'], $pharmacy_medicine_det['price'], $pharmacy_medicine_det['medURL']);
    }

    public function getMedName() {
        return ($this->medicine)['name'];
    }

    public function getPharmName() {
        return ($this->pharmacy)->getName();
    }

    public function getPharmArea() {
        return ($this->pharmacy)->getArea();
    }

    public function getMedPrice() {
        return ($this->pharmacy_medicine)->getMedPrice();
    }

    public function getMedQuantity() {
        return ($this->pharmacy_medicine)->getamount();
    }

    public function getMedURL() {
        return ($this->pharmacy_medicine)->getmedURL();
    }

    public function addToCart($amount) {
        $this->med_det_model->addToCart($amount);
    }

    public function getPharmDelAvailability() {
        return ($this->pharmacy)->deliveryServiceStatus();
    }
}

?>