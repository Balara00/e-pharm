<?php

class Pharmacy_
{

    private static $pharmArr = array();
    private $name;
    private $area;
    private $contactNo;
    private $address;
    private $dvState;
    private $dvOrders;


    private  function __construct()
    {
    }

    public static function getInstance($pharmID)
    {
        if (!(array_key_exists($pharmID, self::$pharmArr))) {
            (self::$pharmArr)[$pharmID] = new Pharmacy_();
        }
        return (self::$pharmArr)[$pharmID];
    }

    public function setAll($name, $area, $contactNo, $address, $dvState, $dvOrders)
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
