<?php

class NavBarContr {
    private $navBar_model;

    public function __construct() {
        $this->navBar_model = new NavBarModel();
    }

    public function getCustomerNotificationNo($customerID) {
        return count($this->navBar_model->getCustomerNotificationIDs($customerID));
    }
    
    public function getPharmacyNotificationNo($pharmacyID) {
        return count($this->navBar_model->getPharmacyNotificationIDs($pharmacyID));
    }
}

?>