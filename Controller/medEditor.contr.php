<?php
include "controller.php";

class MedEditorContr extends Controller {
    private $medID;
    private $pharmacyID;

    private $med_edit_model;
    private $medicine;
    private $pharmacy_medicine;

    public function __construct() {
        $this->med_edit_model = new MedEditorModel();
        $this->medID = $_GET['medID'];
        $this->pharmacyID =  $_GET['pharmacyID'];

        $this->setMedObj( $this->med_edit_model->getMedDetails() );
        $this->setPharmMedObj( $this->med_edit_model->getPharmMedDetails() );
    }

    public function setMedObj($medicine_det) {
        Medicine::setName_($this->medID, $medicine_det['name']);
        $this->medicine = Medicine::getAll($this->medID);
    }

    public function setPharmMedObj($pharmacy_medicine_det) {
        $this->pharmacy_medicine = new PharmacyMedicine($this->pharmacyID, $this->medID, $pharmacy_medicine_det['amount'], $pharmacy_medicine_det['price'], $pharmacy_medicine_det['medURL']);
    }

    public function getMedName() {
        return ($this->medicine)['name'];
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

    public function saveMedChanges($amount, $price, $date) {
        $this->med_edit_model->saveMedChanges($amount, $price);

        if ($this->getMedQuantity() == 0 && $amount != 0) {
            $notify_det = $this->med_edit_model->getNotifyAvailabilityDetails();
            
            foreach ($notify_det as $notify_i) {
                $pharm_det = $this->med_edit_model->getPharmDet();
                if ($notify_i['area'] == $pharm_det['area']) {
                    $notification = $this->getMedName() . " is available now in " . $pharm_det['name'] ." - " . $pharm_det['area'];
                  

                    $this->med_edit_model->sendNotification($notify_i['customerID'], $notification, $date);

                    $this->med_edit_model->setNotifyStatus($notify_i['customerID'], $notify_i['area']);
                }
            }
            
            
        }
    }

}

?>