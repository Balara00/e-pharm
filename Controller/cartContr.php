<?php

class CartContr extends Controller
{
    private $cartModel;
    public function __construct()
    {
        $this->cartModel = new CartModel();
    }
    public function getCart($customerID)
    {
        $cart = $this->setCart($customerID);
        $data = $cart->getData();
        ksort($data);
        return $data;
    }
    private function setCart($customerID)
    {
        $cart = $this->cartModel->getDetails($customerID);
        $cartObj = new Cart();
        foreach ($cart as $entry) {
            $amount = $entry['amount'];
            $pharmacyAmount = $this->cartModel->getmedAmount($entry['pharmacyID'], $entry["medID"]);
            // if ($entry['amount'] > $pharmacyAmount) {
            //     $amount = $pharmacyAmount;
            //     $this->cartModel->setCartAmount($customerID, $entry['pharmacyID'], $entry["medID"], $amount);
            // } else {
            //     $amount = $entry['amount'];
            // }
            if (array_key_exists($entry["pharmacyID"], $cartObj->getData())) {
                $cartObj->addMed($entry['pharmacyID'], array($entry["medID"], $amount, $pharmacyAmount));
            } else {
                $cartObj->addPharm($entry['pharmacyID'], array($entry["medID"], $amount, $pharmacyAmount));
            }
        }
        return $cartObj;
    }
    public function getPharmMed($pharmacyID, $medID)
    {
        return new PharmacyMedicine($this->cartModel->getMedPrice($pharmacyID, $medID), $this->cartModel->getmedImg($pharmacyID, $medID), $this->cartModel->getMedAmount($pharmacyID, $medID));
    }
    public function getMed($medID)
    {
        return new Medicine($this->cartModel->getMedName($medID));
    }
    public function getPharm($pharmacyID)
    {
        $pharmDetailArr = $this->cartModel->getPharmArr($pharmacyID);
        $pharm = Pharmacy_::getInstance($pharmacyID);
        $pharm->setAll($pharmDetailArr['name'], $pharmDetailArr['area'], $pharmDetailArr['contactNo'], $pharmDetailArr['address'], $pharmDetailArr['deliveryServiceStatus'], $pharmDetailArr['dvOrdersPerDay']);
        return $pharm;
        //return new Pharmacy($pharmDetailArr['name'], $pharmDetailArr['area'], $pharmDetailArr['contactNo'], $pharmDetailArr['address'], $pharmDetailArr['deliveryServiceStatus'], $pharmDetailArr['dvOrdersPerDay']);
    }
    public function removeMed($customerID, $pharmacyID, $medID)
    {
        $this->cartModel->removeMed($customerID, $pharmacyID, $medID);
    }
    public function setCartAmount($customerID, $pharmID, $medID, $amount)
    {
        $this->cartModel->setCartAmount($customerID, $pharmID, $medID, $amount);
    }
    public function canBuyNow($dvStatus, $dvOrders, $pharmID)
    {
        if ($dvStatus == 0) {
            return "Delivery service is not available now.";
        } else {
            if ($dvOrders == $this->cartModel->getCurrentOrders($pharmID)) {
                return "Maximum number of delivery orders per day is exceeded for today.";
            }
        }
        return "enable";
    }
}
