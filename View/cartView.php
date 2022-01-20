<?php

class CartView
{
    private $cartContr;
    public function __construct()
    {
        $this->cartContr = new CartContr();
    }
    public function showCart($customerID)
    {
        return $this->cartContr->getCart($customerID);
    }

    public function getPharmMed($pharmacyID, $medID)
    {
        return $this->cartContr->getPharmMed($pharmacyID, $medID);
    }

    public function getMed($medID)
    {
        return $this->cartContr->getMed($medID);
    }
    public function getPharm($pharmacyID)
    {
        return $this->cartContr->getPharm($pharmacyID);
    }
    public function canBuyNow($dvStatus, $dvOrders, $pharmacyID)
    {
        return $this->cartContr->canBuyNow($dvStatus, $dvOrders, $pharmacyID);
    }
}
