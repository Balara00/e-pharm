<?php

class Medicine{

    private $medID;
    private $name;
    private static $multitonArray=array();

    private function __Construct($medID){
        $this->medID = $medID;
    }

    public static function getInstance($key){
        if(!array_key_exists($key, self::$multitonArray)){
            self::$multitonArray[$key] = new Medicine($key);
        }
        return self::$multitonArray[$key];
    }

    public static function setMedName($medID,$name){
        $medicine = self::getInstance($medID);
        $medicine->setname($name);
        
    }
    
    
    
    public function setname($name){
        $this->name = $name;
    }

    public static function getAll($medID){
        $array=array();
        $medicine = self::getInstance($medID);
        $array['medID'] = $medID;
        $array['name'] = $medicine->getname();
        return $array;
    }

    public function getmedID(){
        return $this->medID;
    }

    public function getname(){
        return $this->name;
    }

}