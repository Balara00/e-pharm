<?php

class PickUpOrder extends Order {
    private $customerID;
    private $pharmacyID;
    private $price;
    private $status;
    private $date;
    private $prescURL;
    private $contactNo;

    public function __construct($customerID, $pharmacyID, $price, $date, $prescURL, $contactNo) {
        $this->customerID = $customerID;
        $this->pharmacyID = $pharmacyID;
        $this->price = $price;
        $this->date = $date;
        $this->prescURL = $prescURL;
        $this->contactNo = $contactNo;
    }

    public function process($orderNow_model) {
        $orderNow_model->placeOrder($this->customerID, $this->pharmacyID, 'pickup', $this->price, $this->date, $this->prescURL, '');
    }

    public function setOrderCustomer($orderNow_model, $orderID) {
        $orderNow_model->setOrderCustomer($orderID, $this->customerID, $this->contactNo, '');
    }
}