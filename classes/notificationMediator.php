<?php
// include "pharmacy.php";

class NotificationMediator {
    private $pharmacyList;

    public function __construct() {
        $this->pharmacyList = array();
    }

    public function addUser($pharmacy) {
        array_push($this->pharmacyList, $pharmacy);
    }

    public function sendNotification($notifyTime) {
        $pharmacy_model = new PharmacyModel();

        foreach ($this->pharmacyList as $pharmacy) {
            $pharmacy_model->sendNotification($pharmacy->getPharmacyID(), $notifyTime);


        }
    }

    // public function sendNotification($notification, $prescID, $pharmacyID, $notifyTime) {
    //     $pharmacy_model = new PharmacyModel();
    //     // echo $pharmacyID;
    //     // echo $notification;
    //     // echo $prescID;
    //     // echo $notifyTime;
    //     $pharmacy_model->sendNotification($notification, $prescID, $pharmacyID, $notifyTime);

    // }

}