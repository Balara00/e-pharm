<?php

class NotificPharmModel
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getPDO();
    }
    public function getNotifications($pharmID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy_notification WHERE pharmacyID=:temp");
        $stmt->execute([':temp' => $pharmID]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_reverse($notifications);
    }
    public function setOld($pharmID)
    {
        $sql = "UPDATE pharmacy_notification SET isNew=0 WHERE pharmacyID=:pharmID AND isNew=1";
        $this->pdo->prepare($sql)->execute(array(
            ':pharmID' => $pharmID,
        ));
    }
    public function setRead($notificID)
    {
        echo $notificID;
        $sql = "UPDATE pharmacy_notification SET notificationState=:isRead WHERE notificationID=:notificID";
        $this->pdo->prepare($sql)->execute(array(
            ':isRead' => '1',
            ':notificID' => $notificID,
        ));
    }
    public function combineNotifications($pharmID)
    {
        $notification = "New prescription has uploaded. Check for availability of medicines.";
        $stmt = $this->pdo->prepare("SELECT notificationID FROM pharmacy_notification WHERE pharmacyID=:pharmID AND notification=$notification AND isNew=1");
        $stmt->execute(array(':pharmID' => $pharmID));
        $noOfnew = count($stmt->fetchAll(PDO::FETCH_ASSOC));
        $stmt = $this->pdo->prepare("DELETE FROM pharmacy_notification WHERE pharmacyID=:pharmID AND notification=$notification AND isNew=1");
        $stmt->execute(array(array(':pharmID' => $pharmID)));
        $notification = $noOfnew . 'prescriptions have uploaded. Check for availability of medicines.';
        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y h:i:s a', time());
        $query = "INSERT INTO pharmacy_notification (pharmacyID,notification,dateTime,notificationState,isNew) 
        VALUES(:pharmID,notification,$date,0,1)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            ':pharmID' => $pharmID

        ));
    }
}
