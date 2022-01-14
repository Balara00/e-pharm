<?php

if(isset($_GET['find'])){
    $searchq = $_GET['search'];
    if (!empty($searchq)) {
        $area = $_GET['area'];
        // $customerID = $_SESSION['customerID'];
        if ($area != 'Area') {

            include "../classes/dbconnection.php";
            include "../Model/results_model.php";
            include "../Controller/results_contr.php";
            $medID;
            $medPrice;
            $pharmacyIDs;
            $pharmacyID_pharmacy;

            $resultsCon = new ResultsContr($searchq, $area, 1234);
            
            if(! $resultsCon->searchMed($searchq)){
                $resultsCon->view("result-errorView");
                die;
            }else{
                $medID = $resultsCon->getmedID();
                $medPrice = $resultsCon->getmedPrice();
            }

            $resultsCon->searchPharmaciesInArea($area);
            $pharmacyIDs = $resultsCon->getpharmacyIDs();
            $pharmacyID_pharmacy = $resultsCon->getpharmacyID_pharmacy();

            
            if(! $resultsCon->searchPharmacyMed($pharmacyIDs, $medID)){
                echo '<div class="search-results">No available pharmacies with' . ' ' . $searchq . '</div>';

            }else{
                
            }

        }else{
            echo '<div class="search-results">
                        Select an area.</div>';
        }
    }
}