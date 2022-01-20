<?php

class NotificView
{
    private $notificContr;
    public function __construct()
    {
        $this->notificContr = new NotificContr();
    }
    public function getNotifications($userID)
    {
        return $this->notificContr->getNotifications($userID);
    }
    public function getPharm($pharmacyID)
    {
        return $this->notificContr->getPharm($pharmacyID);
    }
    public function setRead($notificID)
    {
        $this->notificContr->setRead($notificID);
    }
}
