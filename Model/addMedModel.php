<?php

class AddMedModel
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getPDO();
    }
    public function getMedID($name)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM medicine WHERE lower(name)=:temp");
        $stmt->execute([':temp' => strtolower($name)]);
        $med = $stmt->fetch();
        if ($med) {
            if (strtolower($med['name']) === strtolower($name)) {
                return $med['medID'];
            }
        }

        return 0;
    }
    public function addMed($name)
    {
        //echo $name;
        $query = "INSERT INTO medicine (name) VALUES(:name)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            ':name' => $name,
        ));
        $stmt = $this->pdo->prepare("SELECT medID FROM medicine WHERE name=:temp");
        $stmt->execute([':temp' => $name]);
        $medID = $stmt->fetch();
        return $medID['medID'];
    }
    public function addPharmMed($medID, $pharmID, $amount, $price, $medURL)
    {
        $query = "INSERT INTO pharmacy_medicine (pharmacyID,medID,amount,price,medURL) VALUES(:pharmID,:medID,:amount,:price,:medURL)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            ':pharmID' => $pharmID,
            ':medID' => $medID,
            ':amount' => $amount,
            ':price' => $price,
            ':medURL' => $medURL
        ));
    }
    public function isPharmMed($pharmID, $name)
    {
        $medID = $this->getMedID($name);
        if (!($medID == 0)) {
            $stmt = $this->pdo->prepare("SELECT * FROM pharmacy_medicine WHERE medID=:temp AND pharmacyID = :temp1");
            $stmt->execute(array(':temp' => $medID, ':temp1' => $pharmID));
            $PharmMed = $stmt->fetch();
            if ($PharmMed) {
                if ($PharmMed['medID'] == $medID and $PharmMed['pharmacyID'] == $pharmID) {
                    return 1;
                }
            }
        }
        return 0;
    }
    public function getNotifyAvailabilityDetails($medID)
    {
        $stmt = $this->pdo->prepare("SELECT `customerID`, `area` FROM notifyavailability WHERE medID = :medID AND status = :status");
        $stmt->execute(array(":medID" => $medID, ":status" => 'pending'));
        $notify_det = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($notify_det === false) {
            $_SESSION['error'] = "Can't find notify available record in database table course.";
            echo $_SESSION['error'];
            // header("Location: index.php");
        }

        // $pharm_med = new PharmacyMedicine($this->pharmacyID, $this->medID, $pharm_medDet['amount'], $pharm_medDet['medURL']);

        // return $pharm_med;
        return $notify_det;
    }
    public function getPharmDet()
    {
        $stmt = $this->pdo->prepare("SELECT `name`, `area` FROM pharmacy WHERE pharmacyID = :pharmacyID");
        $stmt->execute(array(":pharmacyID" => $_SESSION['pharmacyID']));
        $pharmDet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pharmDet === false) {
            $_SESSION['error'] = "Can't find pharmacy record in database table course.";
            echo $_SESSION['error'];
            // header("Location: index.php");
        }

        // Medicine::setNamePrice($this->medID, $medDet['name'], $medDet['price']);

        // return Medicine::getAll($this->medID);
        return $pharmDet;
    }
    public function sendNotification($customerID, $notification, $notifyTime)
    {
        $pharmacyID = $_SESSION['pharmacyID'];
        // $sql = "INSERT INTO `pharmacy_notification`(`prescID`, `pharmacyID`, `notification`, `dateTime`, `notificationState`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')";
        $stmt = $this->pdo->prepare('INSERT INTO `customer_notification`(`customerID`, `pharmacyID`, `Notification`, `dateTime`, `isRead`)
         VALUES (:cid, :pid, :note, :dateAndTime, "0")');
        $stmt->execute(array(
            ':cid' => $customerID,
            ':pid' => $pharmacyID,
            ':note' => $notification,
            ':dateAndTime' => $notifyTime
        ));


        $_SESSION['successNotify'] = "Notifications sent";
        // header("Location: ../uploadPrescription.php?customerID=".$_GET['customerID']);

        return;
    }
    public function setNotifyStatus($customerID, $area, $medID)
    {
        $sql = "UPDATE `notifyavailability` SET `status` = :status WHERE customerID = :customerID AND medID = :medID AND area = :area";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            ':status' => 'notified',
            ':customerID' => $customerID,
            ':medID' => $medID,
            ':area' => $area
        ));

        $_SESSION['successChangeStatus'] = "Status Changed";
        // header("Location: ../medEditor.php?pharmacyID=" .$this->pharmacyID. "&medID=" .$this->medID);
        return;
    }
}
