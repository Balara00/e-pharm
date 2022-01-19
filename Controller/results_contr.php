<?php

require_once('Controller.php');
include "../classes/dbconnection.php";
include "../Model/results_model.php";
include "../Classes/pharmacy_medicine.php";

class ResultsContr extends Controller{

    private $resultsModel;
    private $searchq;
    private $area;
    private $customerID;
    private $pharmacyIDs;
    private $pharmacyID_pharmacy;
    private $medID;
    
    private $outOfStockCount;
    private $count;

    public function displaySearch(){
        if(isset($_GET['find'])){
            if (!empty($this->searchq)) {
                // $customerID = $_SESSION['customerID'];
                if ($this->area != 'Area') {
                    
                    if(! $this->searchMed($this->searchq)){
                        $_SESSION['searchq']=$this->searchq;
                        $this->view("result-errorView");
                        die();
                    }
                    $this->searchPharmaciesInArea($this->area);
        
                    $result =  $this->searchPharmacyMed($this->pharmacyIDs, $this->medID);
                    if($result == null){
                        echo '<div class="search-results">No available pharmacies with' . ' ' . $this->searchq . '</div>';
        
                    }else{
                        $_SESSION['result']=$result;
                        $_SESSION['pharmacyID_pharmacy']=$this->pharmacyID_pharmacy;
                        $_SESSION['searchq']=$this->searchq;
                        $this->view("results-tableView");
                    }
                }else{
                    echo '<div class="search-results"> Select an area.</div>';        
                }
            }
        }
    }
    public function __construct($customerID){
        $this->searchq = preg_replace('/[0-9\@\.\;\" "]+/', '', $_GET['search']);
        $this->area = $_GET['area'];
        $this->customerID = $customerID;
        $this->resultsModel = new ResultsModel();
        $this->pharmacyIDs = array();
        $this->outOfStockCount=0;
    }

    public function searchMed($searchq){
        $result = $this->resultsModel->searchResult($searchq);
        if($result == null){
            return false;
        }else{
        $this->medID = $result['medID'];
        $this->searchq = $result['name'];
        return true;
        }
    }

    public function searchPharmaciesInArea($area){
        $result = $this->resultsModel->searchPharmacy($area);
        
        foreach($result as $row){
            $id = $row['pharmacyID'];
            array_push($this->pharmacyIDs, $id);
            $this->pharmacyID_pharmacy["$id"] = $row['name'];
        }
    }

    public function searchPharmacyMed($pharmacyIDs, $medID){
        $result = $this->resultsModel->searchPharmacyMeds($pharmacyIDs, $medID);
        foreach($result as $row){
            $this->count++;
        }
        
         return $result;

    }

    public function searchNotify($customerID, $medID, $area){
        $result = $this->resultsModel->searchNotifyAvailbility($customerID, $medID, $area);
        return $result;
    }

    public function setNotify($customerID,$medID,$area,$status){
        
        $this->resultsModel->setNotifyAvailability($customerID,$medID,$area,$status);
    }

    public function updateNotify($customerID,$medID,$area,$status){
        $this->resultsModel->updateNotifyAvailability($customerID,$medID,$area,$status);
    }

    

    /*Getters */
    public function getmedID(){
        return $this->medID;
    }
    public function getarea(){
        return $this->area;
    }
    public function getCount(){
        return $this->count;
    }
    public function getsearchq(){
        return $this->searchq;
    }
    
    public function getcustomerID(){
        return $this->customerID;
    }
    public function getpharmacyIDs(){
        return $this->pharmacyIDs;
    }
    public function getoutOfStockCount(){
        return $this->outOfStockCount;
    }
    public function getpharmacyID_pharmacy(){
        return $this->pharmacyID_pharmacy;
    }
    public function incrementOutOfStcokCount(){
        $this->outOfStockCount++;
    }
    
}