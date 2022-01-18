<?Php

class NotificPharmContr extends Controller
{
    private $notificModel;
    public function __construct()
    {
        $this->notificModel = new NotificPharmModel();
    }
    public function getNotifications($pharmID)
    {
        $this->notificModel->setOld($pharmID);
        return $this->notificModel->getNotifications($pharmID);
    }
    public function setRead($notificID)
    {
        $this->notificModel->setRead($notificID);
    }
}
