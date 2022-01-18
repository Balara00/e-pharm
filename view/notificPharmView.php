<?php

class NotificPharmView
{
    private $notificContr;
    public function __construct()
    {
        $this->notificContr = new NotificPharmContr();
    }
    public function getNotifications($userID)
    {
        return $this->notificContr->getNotifications($userID);
    }
    public function setRead($notificID)
    {
        $this->notificContr->setRead($notificID);
    }
}
