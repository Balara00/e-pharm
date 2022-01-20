<?php

class cartModel
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getPDO();
    }
    public function getDetails($customerID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cart WHERE customerID=:temp");
        $stmt->execute([':temp' => $customerID]);
        $cartDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $cartDetails;
    }
    public function getmedAmount($pharmacyID, $medID)
    {
        $stmt = $this->pdo->prepare("SELECT amount FROM pharmacy_medicine WHERE pharmacyID=:temp AND medID=:temp1");
        $stmt->execute(array(':temp' => $pharmacyID, ':temp1' => $medID));
        $amount = ($stmt->fetch())['amount'];
        return $amount;
    }
    public function getmedImg($pharmacyID, $medID)
    {
        $stmt = $this->pdo->prepare("SELECT medURL FROM pharmacy_medicine WHERE pharmacyID=:temp AND medID=:temp1");
        $stmt->execute(array(':temp' => $pharmacyID, ':temp1' => $medID));
        $img = ($stmt->fetch())['medURL'];
        return $img;
    }
    public function setCartAmount($customerID, $pharmacyID, $medID, $amount)
    {
        $sql = "UPDATE cart SET amount=:amount WHERE customerID=:customerID AND pharmacyID=:pharmacyID AND medID=:medID";
        $this->pdo->prepare($sql)->execute(array(
            ':amount' => $amount,
            ':customerID' => $customerID,
            ':pharmacyID' => $pharmacyID,
            ':medID' => $medID
        ));
        $_SESSION['success'] = "success";
        return;
    }
    public function getMedName($medID)
    {
        $stmt = $this->pdo->prepare("SELECT `name` FROM medicine WHERE medID=:temp");
        $stmt->execute(array(':temp' => $medID));
        $name = ($stmt->fetch())['name'];
        return $name;
    }
    public function getMedPrice($pharmacyID, $medID)
    {
        $stmt = $this->pdo->prepare("SELECT price FROM pharmacy_medicine WHERE pharmacyID=:temp AND medID=:temp1");
        $stmt->execute(array(':temp' => $pharmacyID, ':temp1' => $medID));
        $price = ($stmt->fetch())['price'];
        return $price;
    }
    public function getPharmArr($pharmacyID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy WHERE pharmacyID=:temp");
        $stmt->execute([':temp' => $pharmacyID]);
        $pharmDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $pharmDetails[0];
    }
    public function removeMed($customerID, $pharmacyID, $medID)
    {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE customerID=:temp AND pharmacyID=:temp1 AND medID=:temp2");
        $stmt->execute(array(':temp' => $customerID, ':temp1' => $pharmacyID, 'temp2' => $medID));
        return;
    }
    public function getCurrentOrders($pharmID)
    {
        date_default_timezone_set('Asia/Colombo');
        $date = date('m/d/Y', time());
        $stmt = $this->pdo->prepare("SELECT orderID FROM order_ WHERE pharmacyID=:pID AND orderType=:ot AND dateTime LIKE '%{$date}%' AND approveStatus != 'declined' AND status != 'cancelled'");
        $stmt->execute(array(':pID' => $pharmID, ':ot' => 'delivery'));
        $len = count($stmt->fetchAll(PDO::FETCH_ASSOC));
        return $len;
    }
}
