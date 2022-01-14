<?php

class MedEditorModel {
    private $medID;
    private $pharmacyID;
    private $pdo;

    public function __construct() {
        $this->medID = $_GET['medID'];
        $this->pharmacyID =  $_GET['pharmacyID'];
        $this->pdo = DBConnection::getInstance()->getPDO();
        
    }

    public function getMedDetails() {
        $stmt = $this->pdo -> prepare("SELECT `name` FROM medicine WHERE medID = :medID");
        $stmt -> execute(array(":medID" => $this->medID));
        $medDet = $stmt -> fetch(PDO::FETCH_ASSOC);  

        if ($medDet === false) {
            $_SESSION['error'] = "Can't find medicine record in database table course.";
            echo $_SESSION['error'];
            // header("Location: index.php");
        }

        // Medicine::setNamePrice($this->medID, $medDet['name'], $medDet['price']);

        // return Medicine::getAll($this->medID);
        return $medDet;
    }

    public function getPharmMedDetails() {
        $stmt = $this->pdo -> prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID = :pharmacyID AND medID = :medID");
        $stmt -> execute(array(":pharmacyID" => $this->pharmacyID, ":medID" => $this->medID));
        $pharm_medDet = $stmt -> fetch(PDO::FETCH_ASSOC); 

        if ($pharm_medDet === false) {
            $_SESSION['error'] = "Can't find pharmacy medicine record in database table course.";
            echo $_SESSION['error'];
            // header("Location: index.php");
        }

        // $pharm_med = new PharmacyMedicine($this->pharmacyID, $this->medID, $pharm_medDet['amount'], $pharm_medDet['medURL']);

        // return $pharm_med;
        return $pharm_medDet;
    }

    public function saveMedChanges($amount, $price) {
        $sql = "UPDATE `pharmacy_medicine` SET `amount` = :amount, `price` = :price WHERE pharmacyID = :pharmacyID AND medID = :medID";
        $stmt = $this->pdo -> prepare($sql);
        $stmt -> execute(array(
            ':amount' => $amount,
            ':price' => $price,
            ':pharmacyID' => $this->pharmacyID,
            ':medID' => $this->medID,
        ));

        $_SESSION['success'] = "Save Changed";
        // header("Location: ../medEditor.php?pharmacyID=" .$this->pharmacyID. "&medID=" .$this->medID);
        return;
    }

    public function getNotifyAvailabilityDetails() {
        $stmt = $this->pdo -> prepare("SELECT `customerID`, `area` FROM notifyavailability WHERE medID = :medID AND status = :status");
        $stmt -> execute(array(":medID" => $this->medID, ":status" => 'pending'));
        $notify_det = $stmt -> fetchAll(PDO::FETCH_ASSOC); 

        if ($notify_det === false) {
            $_SESSION['error'] = "Can't find notify available record in database table course.";
            echo $_SESSION['error'];
            // header("Location: index.php");
        }

        // $pharm_med = new PharmacyMedicine($this->pharmacyID, $this->medID, $pharm_medDet['amount'], $pharm_medDet['medURL']);

        // return $pharm_med;
        return $notify_det;
    }

    public function getPharmDet() {
        $stmt = $this->pdo -> prepare("SELECT `name`, `area` FROM pharmacy WHERE pharmacyID = :pharmacyID");
        $stmt -> execute(array(":pharmacyID" => $this->pharmacyID));
        $pharmDet = $stmt -> fetch(PDO::FETCH_ASSOC);  

        if ($pharmDet === false) {
            $_SESSION['error'] = "Can't find pharmacy record in database table course.";
            echo $_SESSION['error'];
            // header("Location: index.php");
        }

        // Medicine::setNamePrice($this->medID, $medDet['name'], $medDet['price']);

        // return Medicine::getAll($this->medID);
        return $pharmDet;
    }

    public function sendNotification($customerID, $notification, $notifyTime) {
        
        // $sql = "INSERT INTO `pharmacy_notification`(`prescID`, `pharmacyID`, `notification`, `dateTime`, `notificationState`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')";
        $sql = "INSERT INTO `customer_notification`(`customerID`, `pharmacyID`, `notification`, `dateTime`) VALUES (:customerID, :pharmacyID, :notification, :dateTime)";
        
        $stmt = $this->pdo -> prepare($sql);

        echo $sql;
        echo '<br>';


        $stmt -> execute(array(
            ':customerID' => $customerID,
            ':pharmacyID' => $this->pharmacyID,
            ':notification' => $notification,
            ':dateTime' => $notifyTime
        ));

        echo "appiriyaaaaaaaaay";
        
        $_SESSION['successNotify'] = "Notifications sent";
        // header("Location: ../uploadPrescription.php?customerID=".$_GET['customerID']);

        return;
    }

    public function setNotifyStatus($customerID, $area) {
        $sql = "UPDATE `notifyavailability` SET `status` = :status WHERE customerID = :customerID AND medID = :medID AND area = :area";
        $stmt = $this->pdo -> prepare($sql);
        $stmt -> execute(array(
            ':status' => 'notified',
            ':customerID' => $customerID,
            ':medID' => $this->medID,
            ':area' => $area
        ));

        $_SESSION['successChangeStatus'] = "Status Changed";
        // header("Location: ../medEditor.php?pharmacyID=" .$this->pharmacyID. "&medID=" .$this->medID);
        return;
    }
}

?>