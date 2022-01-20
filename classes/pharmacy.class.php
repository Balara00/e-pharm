<?php
// include "../Model/pharmacy.model.php";

class Pharmacy{
    private $pharmacyID;
    private $name;
    private $area;
    private $deliveryServiceStatus;
    private $dvOrderNo;
    private $pharmacy_model;

    public function __construct($pharmacyID, $name, $area, $deliveryServiceStatus, $dvOrderNo){
        $this->pharmacyID = $pharmacyID;
        $this->name = $name;
        $this->area = $area;
        $this->deliveryServiceStatus = $deliveryServiceStatus;
        $this->dvOrderNo = $dvOrderNo;
    }

    public function getPharmacyID(){
        return $this->pharmacyID;
    }

    public function getName(){
        return $this->name;
    }

    public function getArea(){
        return $this->area;
    }

    public function deliveryServiceStatus(){
        return $this->deliveryServiceStatus;
    }

    public function getdvOrders() {
        return $this->dvOrderNo;
    }
    // public function sendNotification($notification, $prescID, $pharmacyID, $notifyTime) {
    //     $this->pharmacy_model = new PharmacyModel();

    //     $this->pharmacy_model->sendNotification($notification, $prescID, $pharmacyID, $notifyTime);
    // }
}