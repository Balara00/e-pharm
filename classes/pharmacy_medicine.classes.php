<?php

class PharmacyMedicine
{
    private $price;
    private $amount;
    private $medURL;

    public function __construct($price, $medURL, $amount)
    {
        $this->price = $price;
        $this->medURL = $medURL;
        $this->amount = $amount;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getMedURL()
    {
        return $this->medURL;
    }
    public function getPrice()
    {
        return $this->price;
    }
}
