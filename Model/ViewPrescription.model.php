<?php
//session_start();

class ViewPrescription{

    private $pdo;

    public function __construct(){
        $dbc = DBConnection::getInstance();
        $this->pdo = $dbc->getPDO();
    }

    public function getPharmacy($pid){
        $stmt = $this->pdo->prepare('SELECT * FROM pharmacy WHERE pharmacyID = :pid');
    
        $stmt->execute(array( ':pid' => $pid));
    
        $pharmacyDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pharmacyDetails;
        
    }

    public function getPharmacyArea($pid){
        $pharmacy = $this->getPharmacy($pid);
        return $pharmacy['area'];
    }

    public function getPharmacyName($pid){
        $pharmacy = $this->getPharmacy($pid);
        return $pharmacy['name'];
    }

    public function getPrescriptionIDs($pid, $filter = 'all'){
        if($filter == 'all'){
          
          $stmt = $this->pdo->prepare('SELECT * FROM pharmacy_prescription WHERE pharmacyID = :pid');
          $stmt->execute(array(':pid' => $pid));
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
          
          $stmt = $this->pdo->prepare('SELECT * FROM pharmacy_prescription WHERE pharmacyID = :pid AND approveState = :filter');
          $stmt->execute(array(':pid' => $pid, ':filter' => $filter));
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        //return $prescriptions;
        return $result;
    }

    public function getApproveStat($prescID){
        $stmt = $this->pdo->prepare('SELECT approveState FROM pharmacy_prescription WHERE prescID = :pid');
        $stmt->execute(array(':pid' => $prescID));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['approveState'];
    }

    public function getPrescription($prescID){
        $stmt = $this->pdo->prepare('SELECT * FROM prescription WHERE prescID = :pid ');
        $stmt->execute(array(':pid' => $prescID));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    

    public function setAvailableNotification($prescID, $notification){
        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());
        $pharmacyID = $_SESSION['pharmacyID'];
        $customerID = $this->getPrescription($prescID)['customerID'];
        $stmt = $this->pdo->prepare('INSERT INTO `customer_notification`(`customerID`, `pharmacyID`, `Notification`, `dateTime`, `isRead`)
         VALUES (:cid, :pid, :note, :dateAndTime, "0")');
        $stmt->execute(array(
        ':cid'=>$customerID,
        ':pid' => $pharmacyID, 
        ':note' => $notification, 
        ':dateAndTime' => $date));
        $this->setApproveState($prescID, 'notified');
        return;
    }

    public function setApproveState($prescID, $status){
        $stmt = $this->pdo->prepare('UPDATE `pharmacy_prescription` SET `approveState`=:stat WHERE `pharmacyID`=:pharmID AND `prescID`= :prescID');
        $stmt->execute(array(':pharmID' => $_SESSION['pharmacyID'], ':prescID' => $prescID, ':stat' => $status));
        return;
    }

    

}