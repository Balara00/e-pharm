<?php

class Pharmacy
{
    private $name;
    private $area;
    private $contactNo;
    private $address;
    private $dvState;
    private $dvOrders;
    public function __construct($name, $area, $contactNo, $address, $dvState, $dvOrders)
    {
        $this->name = $name;
        $this->area = $area;
        $this->$contactNo = $contactNo;
        $this->address = $address;
        $this->dvState = $dvState;
        $this->dvOrders = $dvOrders;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getArea()
    {
        return $this->area;
    }
    public function getContactNo()
    {
        return $this->contactNo;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getdvStatus()
    {
        return $this->dvState;
    }
    public function getdvOrders()
    {
        return $this->dvOrders;
    }
}
