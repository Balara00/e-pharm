<?php
//session_start();

class EditUser{

  public function setUserDetails($uid, $name, $address, $email){
    $dbc = DBConn::getConnection();
    $stmt = $dbc->connect()->prepare('UPDATE customer SET name=:name, address=:adrs, username=:email WHERE customerID = :id ');

    $stmt->execute(array( ':name' => $name, ':adrs' => $address, ':email' => $email, ':id' => $uid));
    header("location: ../account.php?customerID=".$_SESSION['customerID']."?success=savedchanges");

  }
}

 ?>
