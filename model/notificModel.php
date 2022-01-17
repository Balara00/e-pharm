<?php

class NotificModel
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getPDO();
    }
    public function getNotifications($customerID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer_notification WHERE customerID=:temp");
        $stmt->execute([':temp' => $customerID]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_reverse($notifications);
    }
    public function setOld($customerID)
    {
        $sql = "UPDATE customer_notification SET isNew=0 WHERE customerID=:customerID AND isNew=1";
        $this->pdo->prepare($sql)->execute(array(
            ':customerID' => $customerID,
        ));
    }
    public function getPharmName($pharmacyID)
    {
        $stmt = $this->pdo->prepare("SELECT `name` FROM pharmacy WHERE pharmacyID=:temp");
        $stmt->execute(array(':temp' => $pharmacyID));
        $name = ($stmt->fetch())['name'];
        return $name;
    }
    public function getPharmArea($pharmacyID)
    {
        $stmt = $this->pdo->prepare("SELECT area FROM pharmacy WHERE pharmacyID=:temp");
        $stmt->execute(array(':temp' => $pharmacyID));
        $area = ($stmt->fetch())['area'];
        return $area;
    }
    public function getPharmArr($pharmacyID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy WHERE pharmacyID=:temp");
        $stmt->execute([':temp' => $pharmacyID]);
        $pharmDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pharmDetails[0];
    }
    public function setRead($notificID)
    {
        echo $notificID;
        $sql = "UPDATE customer_notification SET isRead=:isRead WHERE notificationID=:notificID";
        $this->pdo->prepare($sql)->execute(array(
            ':isRead' => '1',
            ':notificID' => $notificID,
        ));
    }
}
