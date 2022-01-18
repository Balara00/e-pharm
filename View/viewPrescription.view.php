<?php

class ViewPrescription_view extends ViewPrescription{

    public function getFilteredData($filter){
        $prescriptionList = array();
        $result = $this->getPrescriptionIDs($_SESSION['pharmacyID'], $filter);
        foreach($result as $entry){
          $prescID = $entry['prescID'];
          // echo "id: ".$prescID;
          $prescription = $this->getPrescription($prescID);
          if($prescription['prescState']){
            $prescription['approveState'] = $entry['approveState'];
            array_push($prescriptionList, $prescription);
          }
          
        }
        return $prescriptionList;
    }

    public function getApproveState($prescID){
      $result = $this->getApproveStat($prescID);
      return $result;
    }

    public function checkPrescState($prescID){
        $result = $this->getPrescription($prescID);
        $state = $result['prescState'];
        return $state;
    }

    public function printEmptyStatement($filter){
        echo "<p style='color:red'> There's no any ";
        if($filter == 'all'){
          $filter = "";
        }
        echo $filter." prescriptions yet!";
        
    }

    public function printApproveState($results){
        if($results["approveState"] == "notified"){
          echo "<p style='color:green'>Notified</p>";
        }
        elseif($results["approveState"] == "cancelled"){
          echo "<p style='color:red'>Cancelled</p>";
        }
        // elseif($results["ApproveState"] == "Partially"){
        //   echo "<p style='color:grey'>Partially</p>";
        // }
        elseif($results["approveState"] == "pending"){
          echo "<p style='color:blue'>Pending</p>";
        }
      }

}