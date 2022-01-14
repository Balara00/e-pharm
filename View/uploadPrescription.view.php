<?php

class UploadPrescriptionView {
    private $customerID;
    private $uploadPresc_contr;

    public function __construct() {
        $this->customerID = $_GET['customerID'];
        $this->uploadPresc_contr = new UploadPrescriptionContr();
    }

    public function getAreaList() {
        // echo $this->uploadPresc_contr->getAreaList();
        return $this->uploadPresc_contr->getAreaList();
    }
}