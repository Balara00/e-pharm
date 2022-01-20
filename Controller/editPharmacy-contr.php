<?php

class EditPharmacyContr extends EditPharmacy{
    private $name;
    private $address;
    private $area;
    private $contactNumber;

    public function __construct( $name, $address, $area, $contactNumber){
        //$this->$uid = $uid;
        $this->name = $name;
        $this->address = $address;
        $this->area = $area;
        $this->contactNumber = $contactNumber;
    }

    public function editPharmacyDetails(){
        $this->setPharmacyDetails($_SESSION["pharmacyID"], $this->name, $this->address, $this->area, $this->contactNumber);
    }
}