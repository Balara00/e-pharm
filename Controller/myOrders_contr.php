<?php 
require_once('Controller.php');
include "../classes/dbconnection.php";
include "../Model/myOrders_model.php";
include "../Classes/pharmacy.php";
include "../Classes/medicine.php";

class MyOrderContr extends Controller{
    private $customerID;
    private $myOrderModel;
    private $medObjs;
    private $pharmacyObjs;
    private $medIDs;
    private $amounts;

    public function display($name,$type){
        $result = $this->search($this->customerID,$name,$type);
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

                $pharmacyResult = $this->searchPharmacy($row['pharmacyID']);
                array_push($this->pharmacyObjs, new pharmacy($row['pharmacyID'],
                                $pharmacyResult['name'], $pharmacyResult['area']));

            }
            
            $_SESSION['result'] = $result;
            $_SESSION['medObjs'] = $this->medObjs;
            $_SESSION['pharmacyObjs'] = $this->pharmacyObjs;
            $_SESSION['medIDs'] = $this->medIDs;
            $_SESSION['amounts'] = $this->amounts;

            $this->view("myOrders-tableView");

        }

    }

    public function displayRadio($name,$type){
        if($name == 'All'){
            $this->display('All',$type);

        }elseif($name == 'Pending'){
            $this->display('Pending',$type);

        }elseif($name == 'Received'){
            $this->display('Received',$type);

        }elseif($name == 'Cancelled'){
            $this->display('Cancelled',$type);
        }
    }

    public function __construct(){
        $this->customerID = $_SESSION['customerID'];
        $this->myOrderModel = new MyOrderModel();
        $this->medObjs = array();
        $this->pharmacyObjs = array();
        $this->medIDs = array();
        $this->amounts = array();
    }

    public function search($customerID,$name,$type){
        $result = $this->myOrderModel->searchOrderType($customerID,$name,$type);
        return $result;
    }

    public function searchmedNamePrices($medID){
        $result = $this->myOrderModel->searchmedNamePrice($medID);
        return $result;

    }

    public function searchPharmacy($pharmacyID){
        $result = $this->myOrderModel->searchPharmacyDetails($pharmacyID);
        return $result;
    }
    public function searchOrderMed($orderID){
        $result = $this->myOrderModel->searchOrderMeds($orderID);
        return $result;

    }

    public function updateOrderStatus($status,$orderID){
        $result = $this->myOrderModel->updateStatus($status,$orderID);
        return $result;
    }

    public function getOrder($orderID){
        $result =$this->myOrderModel->searchOrder($orderID);
        return $result;
    }

    public function updateRating($rating, $pharmacyID){
        $result = $this->myOrderModel->updatePharmacyRating($rating,$pharmacyID);
        return $result;
    }

    public function getCustomerID(){
        return $this->customerID;
    }
}