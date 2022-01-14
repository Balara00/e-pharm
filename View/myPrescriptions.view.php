<?php
//include "classes/prescription.classes.php";
class MyPrescriptionView extends MyPrescription{
  

  // public function getPrescriptionDetails(){
  //   //$prescriptions = array();
  //   $result = $this->getPrescriptions($_SESSION["customerID"]);
  //   return $result;
  // }

  public function getFilteredData($filter){
    $result = $this->getPrescriptions($_SESSION["customerID"], $filter);
    return $result;
  }

  

  // public function getArea($results){
  //   return $results["area"];
  // }

  // public function getNote($results){
  //   return $results["note"];
  // }

  public function printEmptyStatement($filter){
    echo "<p style='color:red'> There's no any ";
    if($filter == 'Partially'){
      $filter = "Partially Approved";
    }
    echo $filter." prescriptions yet!";
    
  }

  // public function getApproveState($results){
  //   if($results["ApproveState"] == "Approved"){
  //     echo "<p style='color:green'>Approved</p>";
  //   }
  //   elseif($results["ApproveState"] == "Declined"){
  //     echo "<p style='color:red'>Declined</p>";
  //   }
  //   elseif($results["ApproveState"] == "Partially"){
  //     echo "<p style='color:grey'>Partially</p>";
  //   }
  //   elseif($results["ApproveState"] == "Pending"){
  //     echo "<p style='color:blue'>Pending</p>";
  //   }
  // }

  // public function getPrescURL($results){
  //   return $results["prescURL"];
  // }

  // public function getRemovalState($results){
  //   return $results["prescState"];
  // }

}

?>
