<?php

class NavBarModel {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::getInstance()->getPDO();
    }

    public function getCustomerNotificationIDs($customerID) {
        $stmt = $this->pdo -> prepare("SELECT `notificationID` FROM customer_notification WHERE customerID = :customerID AND isNew = 1");
        $stmt -> execute(array(":customerID" => $customerID));
        $notificationIDs = $stmt -> fetchAll(PDO::FETCH_ASSOC);   

        if ($notificationIDs === false) {
            $_SESSION['error'] = "Can't find notification record in database table course.";
            header("Location: index.php");
        }

        return $notificationIDs;
    }

    public function getPharmacyNotificationIDs($pharmacyID) {
        $stmt = $this->pdo -> prepare("SELECT `notificationID` FROM pharmacy_notification WHERE pharmacyID = :pharmacyID AND isNew = 1");
        $stmt -> execute(array(":pharmacyID" => $pharmacyID));
        $notificationIDs = $stmt -> fetchAll(PDO::FETCH_ASSOC);   

        if ($notificationIDs === false) {
            $_SESSION['error'] = "Can't find notification record in database table course.";
            header("Location: index.php");
        }

        return $notificationIDs;
    }
    
}

?>