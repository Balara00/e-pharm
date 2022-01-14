<?php

class pharmacy{
    private $pharmacyID;
    private $name;
    private $area;

    public function __construct($pharmacyID, $name, $area){
        $this->pharmacyID = $pharmacyID;
        $this->name = $name;
        $this->area = $area;
    }

    public function getpharmacyID(){
        return $this->pharmacyID;
    }
    public function getname(){
        return $this->name;
    }
    public function getarea(){
        return $this->area;
    }
}