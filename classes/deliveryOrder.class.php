<?php

class DeliveryOrder extends Order {
    private $customerID;
    private $pharmacyID;
    private $price;
    private $status;
    private $date;
    private $prescURL;
    private $address;
    private $contactNo;
    private $deliveryStatus;

    public function __construct($customerID, $pharmacyID, $price, $date, $prescURL, $address, $contactNo) {
        $this->customerID = $customerID;
        $this->pharmacyID = $pharmacyID;
        $this->price = $price;
        $this->date = $date;
        $this->prescURL = $prescURL;
        $this->address = $address;
        $this->contactNo = $contactNo;
    }

    public function process($orderNow_model) {
        $orderNow_model->placeOrder($this->customerID, $this->pharmacyID, 'delivery', $this->price, $this->date, $this->prescURL, 'pending');
    }

    public function setOrderCustomer($orderNow_model, $orderID) {
        $orderNow_model->setOrderCustomer($orderID, $this->customerID, $this->contactNo, $this->address);
    }
}