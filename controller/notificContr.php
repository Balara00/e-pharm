<?Php

class NotificContr extends Controller
{
    private $notificModel;
    public function __construct()
    {
        $this->notificModel = new NotificModel();
    }
    public function getNotifications($customerID)
    {
        $this->notificModel->setOld($customerID);
        return $this->notificModel->getNotifications($customerID);
    }
    public function getPharm($pharmacyID)
    {
        $pharmDetailArr = $this->notificModel->getPharmArr($pharmacyID);
        $pharm = Pharmacy_::getInstance($pharmacyID);
        $pharm->setAll($pharmDetailArr['name'], $pharmDetailArr['area'], $pharmDetailArr['contactNo'], $pharmDetailArr['address'], $pharmDetailArr['deliveryServiceStatus'], $pharmDetailArr['dvOrdersPerDay']);
        return $pharm;
        //return new Pharmacy($pharmDetailArr['name'], $pharmDetailArr['area'], $pharmDetailArr['contactNo'], $pharmDetailArr['address'], $pharmDetailArr['deliveryServiceStatus'], $pharmDetailArr['dvOrdersPerDay']);
    }
    public function setRead($notificID)
    {
        $this->notificModel->setRead($notificID);
    }
}
