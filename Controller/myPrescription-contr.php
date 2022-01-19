<?php


class MyPrescriptionContr extends Controller{
    private $prescModel;
    public function __construct(){
        $this->prescModel = new MyPrescription();
    }

    public function removePrescription($pid){
        $this->prescModel->deletePrescription($pid);
        
    }

    public function restorePrescription($pid){
        $this->prescModel->addPrescription($pid);
        
    }
}
?>