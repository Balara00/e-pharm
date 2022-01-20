<?php

class OrderNowModel {
    // private $pharmacyID;
    // private $medQuantityArr;
    private  $pdo;

    public function __construct() {
        // $this->pharmacyID = $_SESSION['pharmacyID'];
        // $this->medQuantityArr = $_SESSION['medQuantityArr'];
        $this->pdo = DBConnection::getInstance()->getPDO();

    }

    public function getPharmMedDetails($medID, $pharmacyID){
        $stmt = $this->pdo -> prepare("SELECT `price`, `medURL` FROM pharmacy_medicine WHERE medID = :medID AND pharmacyID = :pharmID");
        $stmt -> execute(array(":medID" => $medID, ":pharmID" => $pharmacyID));
        $medDetail = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $medDetail;
    }

    public function getMedName($medID) {
        $stmt = $this->pdo -> prepare("SELECT `name` FROM medicine WHERE medID = :medID");
        $stmt -> execute(array(":medID" => $medID));
        $medName = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $medName['name'];
    }

    public function getCustomerDetails($customerID) {
        $stmt = $this->pdo -> prepare("SELECT `address`, `contactNo`, `name` FROM customer WHERE customerID = :customerID");
        $stmt -> execute(array(":customerID" => $customerID));
        $customerDetail = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $customerDetail;
    }

    public function placeOrder($customerID, $pharmacyID, $orderType, $price, $date, $prescURL, $deliveryStatus) {
        $sql = "INSERT INTO `order_`(`customerID`, `pharmacyID`, `orderType`, `price`, `status`, `dateTime`, `prescriptionURL`, `approveStatus`, `deliveryStatus`) VALUES (:customerID, :pharmacyID, :orderType, :price, :status, :date, :prescURL, :approveStatus, :deliveryStatus)";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute(array(
            ':customerID' => $customerID,
            ':pharmacyID' => $pharmacyID,
            ':orderType' => $orderType,
            ':price' => $price,
            ':status' => 'pending',
            ':date' => $date,
            ':prescURL' => $prescURL,
            ':approveStatus' => 'pending',
            ':deliveryStatus' => $deliveryStatus,
        ));

        $_SESSION['success'] = "Confirmed the order";
        echo "Confirmed the order";
        return;
    }

    public function getOrderID() {
        $stmt = $this->pdo -> prepare("SELECT `orderID` FROM order_");
        $stmt -> execute(array());
        $orderIDList = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        if ($orderIDList === false) {
            $_SESSION['error'] = "Can't find orderID record in database table course.";
            header("Location: ../index.php");
        }

        echo "order ID = " . end($orderIDList)['orderID'];
        return end($orderIDList)['orderID'];
        // $stmt = $this->pdo -> prepare("SELECT `prescID` FROM prescription");
        // $stmt -> execute(array());
        // $orderIDList = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        // print_r(end($orderIDList)['prescID']);
        // return;
    }

    public function setOrderMedicine($orderID, $medID, $amount) {
        $sql = "INSERT INTO `order_medicine`(`orderID`, `medID`, `amount`) VALUES (:orderID, :medID, :amount)";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute(array(
            ':orderID' => $orderID,
            ':medID'=> $medID,
            ':amount' => $amount
        ));
        
        return;
    }

    public function setOrderCustomer($orderID, $customerID, $contactNo, $address) {
        $sql = "INSERT INTO `order_customer`(`orderID`, `customerID`, `contactNo`, `address`) VALUES (:orderID, :customerID, :contactNo, :address)";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute(array(
            ':orderID' => $orderID,
            ':customerID'=> $customerID,
            ':contactNo' => $contactNo,
            ':address' => $address
        ));

        return;
 
    }

    public function sendNotification($pharmacyID, $notifyTime) {
        
        $sql = "INSERT INTO `pharmacy_notification`(`pharmacyID`, `notification`, `dateTime`, `isNew`) VALUES (:pharmacyID, :notification, :dateTime, 1)";
        
        $stmt = $this->pdo -> prepare($sql);
////////////////////////////////////////////////////
        $stmt -> execute(array(
            ':pharmacyID' => $pharmacyID,
            ':notification' => 'You have recieved a new order.',
            ':dateTime' => $notifyTime,
        ));
        $_SESSION['success'] = "Notifications sent";
        // header("Location: ../uploadPrescription.php?customerID=".$_GET['customerID']);

        return;
    }

    public function deleteCartItems($customerID, $pharmacyID) {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE customerID=:temp AND pharmacyID=:temp1");
        $stmt->execute(array(':temp' => $customerID, ':temp1' => $pharmacyID));

        $_SESSION['successDlt'] = "Cart item deleted"; 
        return;
    }
}

?>