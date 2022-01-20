<?php

class EditPharmacy{
    public function setPharmacyDetails($pid, $name, $address, $area, $contactNumber){
        $dbc = DBConnection::getInstance();
        $stmt = $dbc->getPDO()->prepare('UPDATE pharmacy SET name=:name, address=:adrs, area=:area, contactNo=:contact WHERE pharmacyID = :id ');
    
        $stmt->execute(array( ':name' => $name, ':adrs' => $address, ':area'=>$area, ':contact' => $contactNumber, ':id' => $pid));
        header("location: ../pharmacyAccount.php?pharmacyID=".$_SESSION['pharmacyID']."?success=savedchanges");
    
      }
}