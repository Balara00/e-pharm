<?php

class ViewPrescriptionContr extends Controller{

    private $viewPrescriptionModel;
    private $prescID;
    private $status;

    public function __construct($status, $prescID){
        $this->viewPrescriptionModel = new ViewPrescription();
        $this->status = $status;
        $this->prescID = $prescID;
    }

    public function executeStatus($notification){
        if($this->status == 'Available'){
            $this->viewPrescriptionModel->setAvailableNotification($this->prescID,$notification);
        }
        elseif($this->status == 'Cancel'){
            $this->viewPrescriptionModel->setApproveState($this->prescID, 'cancelled');
        }
    }

}