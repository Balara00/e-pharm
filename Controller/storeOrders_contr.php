<?php 
require_once('Controller.php');
include "../classes/dbconnection.php";
include "../Model/storeOrders_model.php";
include "../Classes/pharmacy.php";
include "../Classes/medicine.php";

class StoreOrderContr extends Controller{
    
    private $storeOrderModel;
    private $medObjs;
    private $customers;
    private $medIDs;
    private $amounts;
    private $pharmacyID;

    public function display($name,$type){
        $result = $this->search($this->pharmacyID,$name,$type);
        if($result == null){
            echo '<div class="search-results"> No orders to show</div>';
        }else{
            foreach($result as $row){
                $medOrderArray = array();
                $tempMedIds = array();
                $tempAmounts = array();
                
                $temp = $this->searchOrderMed($row['orderID']);
                foreach($temp as $med){
                    $medResult = $this->searchmedNamePrices($med['medID']);
                    Medicine::setMedName($med['medID'], $medResult['name']);
                    array_push($medOrderArray, Medicine::getInstance($med['medID']));
                    array_push($tempMedIds,$med['medID']);
                    array_push($tempAmounts,$med['amount']);
                }

                array_push($this->medObjs,$medOrderArray);
                array_push($this->medIDs,$tempMedIds);
                array_push($this->amounts,$tempAmounts);

                 $customerResult = $this->searchCustomer($row['customerID']);
                 array_push($this->customers, $customerResult);

            }
            
            $_SESSION['result'] = $result;
            $_SESSION['medObjs'] = $this->medObjs;
            $_SESSION['customers'] = $this->customers;
            $_SESSION['medIDs'] = $this->medIDs;
            $_SESSION['amounts'] = $this->amounts;

            $this->view("StoreOrders-tableView");

        }

    }

    public function displayRadio($name,$type){
        if($name == 'All'){
            $this->display('All',$type);

        }elseif($name == 'Pending'){
            $this->display('Pending',$type);

        }elseif($name == 'Accepted'){
            $this->display('Accepted',$type);

        }elseif($name == 'Delivered'){
            $this->display('Delivered',$type);
        }elseif($name == 'Declined'){
            $this->display('Declined',$type);
        }
    }

    public function __construct(){
        $this->storeOrderModel = new StoreOrderModel();
        $this->medObjs = array();
        $this->customers = array();
        $this->medIDs = array();
        $this->amounts = array();
        $this->pharmacyID=$_SESSION['pharmacyID'];
    }

    public function search($pharmacyID,$name,$type){
        $result = $this->storeOrderModel->searchOrderType($pharmacyID,$name,$type);
        return $result;
    }

    public function searchmedNamePrices($medID){
        $result = $this->storeOrderModel->searchmedNamePrice($medID);
        return $result;

    }

    public function searchCustomer($customerID){
        $result = $this->storeOrderModel->searchCustomerDetails($customerID);
        return $result;
    }
    public function searchOrderMed($orderID){
        $result = $this->storeOrderModel->searchOrderMeds($orderID);
        return $result;

    }

    public function updateApproveStatus($status,$orderID){
        $result = $this->storeOrderModel->updateAStatus($status,$orderID);
        return $result;
    }
    public function updateDeliveryStatus($status,$orderID){
        $result = $this->storeOrderModel->updateDStatus($status,$orderID);
        return $result;
    }
    public function reduceAmounts($orderID,$pharmacyID){
        $result= $this->storeOrderModel->reduceMedAmounts($orderID,$pharmacyID);
        return $result;
    }

    public function getOrder($orderID){
        $result =$this->storeOrderModel->searchOrder($orderID);
        return $result;
    }

    // public function updateRating($rating, $pharmacyID){
    //     $result = $this->storeOrderModel->updatePharmacyRating($rating,$pharmacyID);
    //     return $result;
    // }

    public function getCustomerID(){
        return $this->customerID;
    }

    public function isExceeded($pharmID) {
        if ($this->storeOrderModel->getCurrentOrders($pharmID) == $this->storeOrderModel->getDelOrderNo($pharmID)) {
            return true;
        }
        return false;
    }
}