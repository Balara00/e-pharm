<?php

class MedEditorView {
    private $pharmacyID;
    private $medID;
    private $med_edit_contr; 

    public function __construct() {
        $this->pharmacyID = $_GET['pharmacyID'];
        $this->medID = $_GET['medID'];
        
        $this->med_edit_contr = new MedEditorContr();
    }

    public function getPharmacyID() {
        return $this->pharmacyID;
    }

    public function getMedID() {
        return $this->medID;
    }

    public function getMedName() {
        return $this->med_edit_contr->getMedName();
    }

    public function getMedPrice() {
        return $this->med_edit_contr->getMedPrice();
    }

    public function getMedQuantity() {
        return $this->med_edit_contr->getMedQuantity();
    }

    public function getMedURL() {
        return $this->med_edit_contr->getMedURL();
    }

}

?>
