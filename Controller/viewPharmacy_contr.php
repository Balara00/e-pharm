<?php

require_once('Controller.php');
include "../classes/dbconnection.php";
include "../Model/viewPharmacy_model.php";
include "../Classes/pharmacy_medicine.php";
include "../Classes/medicine.php";

class ViewPharmacyContr extends Controller{
    private $viewModel;
    private $searchq;
    private $area;
    private $customerID;
    private $pharmacyID;
    private $medID;
    private $medPrice;
    private $medObjs;

    public function displaySearch($searchq){
            $this->searchq = $searchq;
            if(! $this->searchMed($this->searchq)){
                $_SESSION['searchq']=$this->searchq;
                $this->view("result-errorView");
                die();
            }

            $result = $this->searchMedInPharmacy($this->pharmacyID,$this->medID);
            if($result == null){
                echo '<div class="search-results">'. $this->searchq .' is not available at the moment'. '</div>';
            }else{
                $_SESSION['result']=$result;
                
                $_SESSION['searchq']=$this->searchq;
                $this->view("viewPharmacy-tableView");
            }
        
    }

    public function displayAllItems(){
        $result = $this->viewModel->searchALlItems($this->pharmacyID);
        
        if($result == null){
            echo '<div class="search-results"> No items available at the moment'. '</div>';
        }else{
            foreach($result as $row){
                $medResult = $this->searchmedNamePrices($row['medID']);
                Medicine::setMedName($row['medID'], $medResult['name']);
                array_push($this->medObjs, Medicine::getInstance($row['medID']));
            }
            $_SESSION['medObjs'] = $this->medObjs;
            $_SESSION['result'] = $result;
            $this->view("viewPharmacy-secondtableView");
        }
    }

    public function __construct($pharmacyID){
        
        $this->area = "Kuliyapitiya";
        $this->viewModel = new ViewPharmacyModel();
        $this->pharmacyID = $pharmacyID;
        $this->medObjs = array();
        $this->customerID = $_SESSION['customerID'];
    }
 
    public function searchMed($searchq){
        $result = $this->viewModel->searchResult($searchq);
        if($result == null){
            return false;
        }else{
        $this->medID = $result['medID'];
        
        return true;
        }
    }
    public function searchMedInPharmacy($pharmacyID,$medID){
        $result = $this->viewModel->searchMedPharmacy($pharmacyID,$medID);
        return $result;
    }
    public function searchmedNamePrices($medID){
        $result = $this->viewModel->searchmedNamePrice($medID);
        return $result;

    }
    public function getRatings($pharmacyID){
        $result = $this->viewModel->getRating($pharmacyID);
        return $result;
    }

    public function searchPharmacy($pharmacyID){
        $result = $this->viewModel->searchPharm($pharmacyID);
        return $result;
    }
    public function getcustomerID(){
        return $this->customerID;
    }
    
    public function getsearchq(){
        return $this->searchq;
    }

    public function getMedID(){
        return $this->medPrice;
    }
    public function getMedPrice(){
        return $this->medPrice;
    }
}
