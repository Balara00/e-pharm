<?php

// include "../Controller/medDetail.contr.php";

class NavBarView {
    private $navBar_contr; 

    public function __construct() {
        $this->navBar_contr = new NavBarContr();
    }

    public function getCustomerNotificationNo($customerID) {
        return $this->navBar_contr->getCustomerNotificationNo($customerID);
    }
    
    public function getPharmacyNotificationNo($pharmacyID) {
        return $this->navBar_contr->getPharmacyNotificationNo($pharmacyID);
    }
}

?>
