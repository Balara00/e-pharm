<?php

class Cart
{
    private $data;
    public function __construct()
    {
        $this->data = array();
    }
    public function getData()
    {
        return $this->data;
    }
    public function addMed($pharmacyID, $medEntry)
    {
        array_push(($this->data)[$pharmacyID], $medEntry);
    }
    public function addPharm($pharmacyID, $medEntry)
    {
        ($this->data)[$pharmacyID] = array($medEntry);
    }
}
