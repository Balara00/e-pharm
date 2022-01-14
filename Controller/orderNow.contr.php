<?php
class OrderNowContr{
    private $pharmacyID;
    private $medQuantityArr;
    private $customerID;
    private $customer;
    private $orderNow_model;
    private $order_obj;
    private $medArr;

    public function __construct(){
        $this->pharmacyID = $_SESSION['pharmacyID'];
        $this->medQuantityArr = $_SESSION['medQuantityArr'];
        $this->customerID = $_SESSION['customerID'];
        $this->orderNow_model = new OrderNowModel();
        $this->customer = $this->orderNow_model->getCustomerDetails($this->customerID);
    }

    public function getMedArr(){
        $this->medArr = array();
        foreach ($this->medQuantityArr as $medID => $amount){
            
            $medDetail = $this->orderNow_model->getPharmMedDetails($medID, $this->pharmacyID);

            $med = new PharmacyMedicine($this->pharmacyID, $medID, $amount, $medDetail['price'], $medDetail['medURL']);
            array_push($this->medArr, $med);
        }
        return $this->medArr;
    }

    public function getMedName($obj) {
        return $this->orderNow_model->getMedName($obj->getmedId());
    }

    public function getMedPrice($obj) {
        return $obj->getmedPrice();
    }

    public function getMedQty($obj) {
        return $obj->getamount();
    }

    public function getPrice($obj) {
        return number_format((float)$obj->getmedPrice() * (float)$obj->getamount(), 2);
    }

    public function getCustomerName(){
        return $this->customer['name'];
    }

    public function getCustomerNo() {
        return $this->customer['contactNo'];    
    }

    public function getCustomerAddress() {
        return $this->customer['address'];    
    }

    public function getPrescURL($uploadFile) {
        $fileName = $uploadFile['name'];
        $fileTmpName = $uploadFile['tmp_name'];
        $fileSize = $uploadFile['size'];
        $fileError = $uploadFile['error'];
        $fileType = $uploadFile['type'];
        $fileNameNew = '';

        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
    
        $allowed = array('jpg','jpeg','png');

        if(in_array($fileActualExt,$allowed)) {
            if($fileError === 0) {
                if($fileSize < 1000000) {
                    $fileNameNew = uniqid('',true). "." .$fileActualExt;
                    $fileDestination = '../uploads/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    // $this->uploadPresc_model->uploadPrescription($selectedArea, $this->fileNameNew, $note, $uploadTime);

                }else {
                    $_SESSION['error'] = "file too big";
                }
            }else {
                $_SESSION['error'] = "error in uploading file";
            }
        }else {
            $_SESSION['error'] = "wrong type";
        
        }
        echo $fileNameNew;
      return $fileNameNew;
    }

    public function setDeliveryOrderObj($customerID, $pharmacyID, $price, $date, $prescURL, $address, $contactNo) {
        $this->order_obj = new DeliveryOrder($customerID, $pharmacyID, $price, $date, $prescURL, $address, $contactNo);
    }

    public function setPickUpOrderObj($customerID, $pharmacyID, $price, $date, $prescURL, $contactNo) {
        $this->order_obj = new PickUpOrder($customerID, $pharmacyID, $price, $date, $prescURL, $contactNo);
    }

    public function orderNow() {
        $this->order_obj->process($this->orderNow_model);
    }

    public function setOrderCustomer() {
        $orderID = $this->orderNow_model->getOrderID();
        $this->order_obj->setOrderCustomer($this->orderNow_model, $orderID);
    }

    public function setOrderMedicine() {
        $orderID = $this->orderNow_model->getOrderID();
        foreach ($this->medArr as $med) {
            $this->orderNow_model->setOrderMedicine($orderID, $med->getMedID(), $med->getamount());
        }
    }

}