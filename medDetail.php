<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/medDetail.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    
    <title>View Medicine</title>
</head>

<body class="viewMed_body">

    <?php

    include "classes/dbConnection.class.php";
    include "classes/medicine.class.php";
    include "classes/pharmacy.class.php";
    include "classes/pharmacy_medicine.class.php";
    include "Model/medDetail.model.php"; 
    include "Controller/medDetail.contr.php";
    include "View/medDetail.view.php";

    $med_det_view = new MedDetailView();

    $customerID = $med_det_view->getCustomerID();
    $medID = $med_det_view->getMedID();
    $pharmID = $med_det_view->getPharmacyID();
    $medURL = $med_det_view->getMedURL();
    $pharmName = $med_det_view->getPharmName();
    $pharmArea = $med_det_view->getPharmArea();
    $medName = $med_det_view->getMedName();
    $medPrice = $med_det_view->getMedPrice();
    $medQuantity = $med_det_view->getMedQuantity();
    $isDeliveyAvailable = $med_det_view->getPharmDelAvailability();

    // 
    // $_SESSION['customerID'] = $customerID;
    // 

        if(isset($_SESSION['get'])) {
            header("Location: medDetail.php?customerID=". $customerID ."&medID=". $medID ."&pharmacyID=". $pharmID);
            unset($_SESSION['get']);
            return;
        }

        if(isset($_SESSION['error'])) {
            echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }

    ?>

    <div class="viewMed_container">

        <?php 
        include "navBar.php";
        
            echo '<img class="imgMed" src="uploads/'. $medURL .'">';

            // echo '<form method = "post">';
                
            echo '<form action="includes/medDetail.inc.php?customerID=' . $customerID . '&medID=' . $medID . '&pharmacyID=' . $pharmID. '" method="post">';
        ?>
  
            <div class="medDetails">
                <div class="stripe"> </div>
                <div class="pharmacy">
                    <?php echo ($pharmName. " - ". $pharmArea); ?>
                </div>

                <?php echo '<a class="btn btn-secondary viewPharmacyBtn" href="viewPharmacy.php?pharmacyID='. $pharmID .'">View Pharmacy</a>';?>
            
                <div class="medicine">
                    <?php echo $medName;?>
                </div>
            
                <div class="price">
                    <?php echo "Rs.".$medPrice;?>
                </div>
            
                <div class="quantity">
                    <?php
                        if ($medQuantity == "0") {
                            echo '<p class="outOfStock">Out of Stock</p>';
                            echo '<input type="submit" name="buyNow" class="btn buyNowBtn" value="Buy Now" disabled/>';
                            echo '<input type="submit" name="reserveNow" class="btn btn-primary reserveNowBtn medDetBtn" value="Reserve Now" disabled/>';
                            echo '<input type="submit" name="addToCart" class="btn addToCartBtn" value="Add to Cart" disabled/>';

                        }elseif ($isDeliveyAvailable == 0) {
                            echo '<p class="quantityText">Quantity</p>';
                            echo '<input type="number" id="quantityTxtBox" name="quantityTxt" min="1" max="'. $medQuantity .'" required onKeyDown="return false" value="1">';
                            
                            echo '<input type="submit" name="buyNow" class="btn btn-primary buyNowBtn medDetBtn" value="Buy Now" disabled/>';
                            echo '<input type="submit" name="reserveNow" class="btn btn-primary reserveNowBtn medDetBtn" value="Reserve Now"/>';
                            echo '<input type="submit" name="addToCart"  class="btn btn-danger addToCartBtn medDetBtn" value="Add to Cart" data-bs-toggle="modal" data-bs-target="#myModal"/>';
                          
                        }else{
                            echo '<p class="quantityText">Quantity</p>';
                            echo '<input type="number" id="quantityTxtBox" name="quantityTxt" min="1" max="'. $medQuantity .'" required onKeyDown="return false" value="1">';
                            
                            echo '<input type="submit" name="buyNow" class="btn btn-primary buyNowBtn medDetBtn" value="Buy Now"/>';
                            echo '<input type="submit" name="reserveNow" class="btn btn-primary reserveNowBtn medDetBtn" value="Reserve Now"/>';
                            echo '<input type="submit" name="addToCart"  class="btn btn-danger addToCartBtn medDetBtn" value="Add to Cart" data-bs-toggle="modal" data-bs-target="#myModal"/>';
                          
                    ?>
                </div>
            </form>
            
        </div>
    </div>


    <?php if (isset($_SESSION['success'])) {?>

    <!-- Trigger/Open The Modal -->

        <!-- The Modal -->
        <div id="myModal" class="modal" >

        <!-- Modal content -->
        <div class="modal-content">
        
        <div >
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <img class="imgCart mx-auto" src="assets/images/cart.svg">
            <p class="mx-auto success">Sucessfully added to cart</p>

            <?php
            echo '<a class="btn btn-primary viewCartBtn mx-auto" href="cart.php?customerID='.$customerID.'" role="button">Check out now</a>';
            ?>    
        <!-- </div> -->
            </div>
        </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];


        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

    </script>

    <?php
        unset($_SESSION['success']);
    }
        
} ?>

</body>
</html>