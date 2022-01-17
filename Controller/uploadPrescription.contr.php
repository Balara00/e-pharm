<?php
include "controller.php";

class UploadPrescriptionContr extends Controller {
    private $uploadPresc_model;
    private $notificationMed;
    private $fileNameNew;

    public function __construct() {
        $this->uploadPresc_model = new UploadPrescriptionModel();
        $this->notificationMed = new NotificationMediator();
    }

    public function getAreaList() {
        // echo $this->uploadPresc_model->getAreaList();
        $pharmacyAreaDet = $this->uploadPresc_model->getAreaList();

        $area_array = array();
        
        foreach ($pharmacyAreaDet as $pharmArea) {
          array_push($area_array, (implode("", $pharmArea)));
        }
      
        return array_unique($area_array);
    }

    public function uploadPrescDetails($selectedArea, $uploadedFile, $note, $uploadTime) {
        $fileName = $uploadedFile['name'];
        $fileTmpName = $uploadedFile['tmp_name'];
        $fileSize = $uploadedFile['size'];
        $fileError = $uploadedFile['error'];
        $fileType = $uploadedFile['type'];

        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
    
        $allowed = array('jpg','jpeg','png');

        if(in_array($fileActualExt,$allowed)) {
            if($fileError === 0) {
                if($fileSize < 1000000) {
                    $this->fileNameNew = uniqid('',true). "." .$fileActualExt;
                    $fileDestination = '../uploads/'.$this->fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $this->uploadPresc_model->uploadPrescription($selectedArea, $this->fileNameNew, $note, $uploadTime);

                }else {
                    $_SESSION['error'] = "file too big";
                }
            }else {
                $_SESSION['error'] = "error in uploading file";
            }
        }else {
            $_SESSION['error'] = "wrong type";
        
        }
      
    }

    public function setPharmacyList($area) {
        $pharmDet = $this->uploadPresc_model->getPharmacyList($area);

        $prescID = $this->uploadPresc_model->getPrescID($this->fileNameNew);

        foreach($pharmDet as $pharm) {
            $this->notificationMed->addUser(new Pharmacy($pharm['pharmacyID'], $pharm['name'], $area, $pharm['deliveryServiceStatus']));
            $this->uploadPresc_model->setPharmPresc($pharm['pharmacyID'], $prescID);

        }
    }

    public function sendNotification($uploadTime) {
        $this->notificationMed->sendNotification($uploadTime);

        // $pharmDet = $this->uploadPresc_model->getPharmacyList($area);

        // foreach($pharmDet as $pharm) {
        //     $this->notificationMed->sendNotification($msg, $prescID, $pharm['pharmacyID'], $uploadTime);
        // }
        // return;
    }
}