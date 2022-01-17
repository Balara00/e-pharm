<?php
//  include_once "dbConnection.class.php";

class PharmacyModel {
    private $pdo;


    public function __construct() {
        $this->pdo = DBConnection::getInstance()->getPDO();
        
    }

    public function sendNotification($pharmacyID, $notifyTime) {
        
        // $sql = "INSERT INTO `pharmacy_notification`(`prescID`, `pharmacyID`, `notification`, `dateTime`, `notificationState`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')";
        $sql = "INSERT INTO `pharmacy_notification`(`pharmacyID`, `notification`, `dateTime`) VALUES (:pharmacyID, :notification, :dateTime)";
        
        $stmt = $this->pdo -> prepare($sql);
////////////////////////////////////////////////////
        $stmt -> execute(array(
            ':pharmacyID' => $pharmacyID,
            ':notification' => 'New prescription has uploaded. Check for availability of medicines.',
            ':dateTime' => $notifyTime,
        ));
        $_SESSION['success'] = "Notifications sent";
        // header("Location: ../uploadPrescription.php?customerID=".$_GET['customerID']);

        return;
    }
}

