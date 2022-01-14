<?php

class uploadPrescriptionModel {
    private $customerID;
    private $pdo;

    public function __construct() {
        $this->customerID = $_GET['customerID'];
        $this->pdo = DBConnection::getInstance()->getPDO();

    }

    public function getAreaList() {
        $stmt = $this->pdo -> prepare("SELECT `area` FROM pharmacy");
        $stmt -> execute(array());
        $pharmacyAreaDet = $stmt -> fetchAll(PDO::FETCH_ASSOC);  
      
        if ($pharmacyAreaDet === false) {
            $_SESSION['error'] = "Can't find data record in database table course.";
            header("Location: ../index.php");
        }
      
        return $pharmacyAreaDet;

    }

    public function uploadPrescription($selectedArea, $uploadFile, $note, $uploadTime) {
        $sql = "INSERT INTO `prescription`(`customerID`,`prescURL`,`area`, `note`, `dateTime`, `prescState`) VALUES (:cID, :purl, :area, :note, :date_time, :pstate)";
        $stmt = $this->pdo -> prepare($sql);
        $stmt -> execute(array(
            ':cID' => $this->customerID,
            ':purl' => $uploadFile,
            ':area' => $selectedArea,
            ':note' => $note,
            ':date_time' => $uploadTime,
            ':pstate'=> '1',
        ));

        echo "upload unaaaaaaaaaaaaaa";
        $_SESSION['upload'] = "uploaded";
        return;
    }

    public function getPrescID($fileName) {
        $stmt = $this->pdo -> prepare("SELECT `prescID` FROM prescription WHERE prescURL = :prescURL");
        $stmt -> execute(array(":prescURL" => $fileName));
        $prescID = $stmt -> fetch(PDO::FETCH_ASSOC);   
   

        if ($prescID === false) {
            $_SESSION['error'] = "Can't find prescID record in database table course.";
            header("Location: ../index.php");
        }

        return $prescID['prescID'];
    }

    public function getPharmacyList($area) {
        $stmt = $this->pdo -> prepare("SELECT * FROM pharmacy WHERE area = :area");
        $stmt -> execute(array(":area" => $area));
        $pharmacyDet = $stmt -> fetchAll(PDO::FETCH_ASSOC);   

        if ($pharmacyDet === false) {
            $_SESSION['error'] = "Can't find data record in database table course.";
            header("Location: ../index.php");
        }
        return $pharmacyDet;
    }

    public function setPharmPresc($pharmacyID, $prescID) {
        $sql = "INSERT INTO `pharmacy_prescription`(`pharmacyID`, `prescID`, `approveState`) VALUES (:pharmacyID, :prescID, :approve)";
        $stmt = $this->pdo -> prepare($sql);
        $stmt -> execute(array(
            ':pharmacyID' => $pharmacyID,
            ':prescID' => $prescID,
            ':approve' => 'pending',
        ));

        // $_SESSION['added'] = "added";
        return;
    }
}