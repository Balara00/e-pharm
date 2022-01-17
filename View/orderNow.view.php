<?php

class OrderNowView{
    private $orderNow_contr;

    public function __construct(){
        $this->orderNow_contr = new OrderNowContr();
    }
    
    public function getMedArr(){
        return $this->orderNow_contr->getMedArr();
    }

    public function getMedName($obj) {
        return $this->orderNow_contr->getMedName($obj);
    }

    public function getMedPrice($obj) {
        return $this->orderNow_contr->getMedPrice($obj);
    }

    public function getMedQty($obj) {
        return $this->orderNow_contr->getMedQty($obj);
    }

    public function getPrice($obj) {
        return $this->orderNow_contr->getPrice($obj);
    }

    public function getCustomerName(){
        return $this->orderNow_contr->getCustomerName();
    }

    public function getCustomerNo() {
        return $this->orderNow_contr->getCustomerNo();
    }

    public function getCustomerAddress() {
        return $this->orderNow_contr->getCustomerAddress();
    }
}

