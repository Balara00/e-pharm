<?php
//session_start();

class EditUser{

  public function setUserDetails($uid, $name, $address, $contactNumber){
    $dbc = DBConnection::getInstance();
    $stmt = $dbc->getPDO()->prepare('UPDATE customer SET name=:name, address=:adrs, contactNo=:contact WHERE customerID = :id ');

    $stmt->execute(array( ':name' => $name, ':adrs' => $address, ':contact' => $contactNumber, ':id' => $uid));
    header("location: ../account.php?customerID=".$_SESSION['customerID']."?success=savedchanges");

  }
}

 ?>
