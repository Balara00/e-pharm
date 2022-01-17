<?php 
// require_once('Controller.php');
include "../classes/dbconnection.php";
include "../Model/landing_model.php";

class LandingContr{

    private $landingModel;
    
    public function __construct(){
        $this->landingModel = new LandingModel();
    }

    public function getAreaList(){
        $areas=$this->landingModel->getAreas();
        $dis_array = array();

        foreach ($areas as $x) { 
            array_push($dis_array, (implode("", $x)));
        }


        $result = array();
        for($i=0;$i<count($dis_array);$i++){
            if(!in_array($dis_array[$i],$result)){
                array_push($result,$dis_array[$i]);
            }
        }

        return $result;
    }
}