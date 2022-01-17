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
    <link rel="stylesheet" href="assets/css/medEditor.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    
    <title>Edit Medicine</title>
</head>

<body class="medEdit_body">

    <?php

    include "classes/dbConnection.class.php";
    include "classes/medicine.class.php";
    include "classes/pharmacy_medicine.class.php";
    include "Model/medEditor.model.php"; 
    include "Controller/medEditor.contr.php";
    include "View/medEditor.view.php";

    $med_edit_view = new MedEditorView();

    $medID = $med_edit_view->getMedID();
    $pharmID = $med_edit_view->getPharmacyID();
    $medURL = $med_edit_view->getMedURL();
    $medName = $med_edit_view->getMedName();
    $medPrice = $med_edit_view->getMedPrice();
    $medQuantity = $med_edit_view->getMedQuantity();

        if(isset($_SESSION['get'])) {
            header("Location: medEditor.php?pharmacyID=". $pharmID ."&medID=". $medID);
            unset($_SESSION['get']);
            return;
        }

        // if(!isset($_SESSION['isLogged'])) {

        // }

        if(isset($_SESSION['error'])) {
            echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }

    ?>

    <div class="medEdit_container">

        <?php 
        include "navBar_pharmacy.php";
        
            echo '<img class="imgMed" src="uploads/'. $medURL .'">';
                
            echo '<form action="includes/medEditor.inc.php?pharmacyID=' . $pharmID. '&medID=' . $medID .'" method="post">';
        ?>
  
            <div class="medDetails">
                <div class="stripe"> </div>
            
                <div class="medicine">
                    <?php echo $medName;?>
                </div>
            
                <div class="price">
            
                    <p class="priceText">Price</p>
                    <p class="rupee">Rs.</p>
                    <input type="number" id="medPriceBox" class="medPriceBox" name="medPriceTxt" min="0" required value = <?php echo $medPrice ?> oninput="validity.valid||(value='');" step="any" required>

                
                </div>
            
                <div class="quantity">
                        
                        <p class="quantityText">Quantity</p>
                        <input type="number" id="quantityTxtBox" name="quantityTxt" min="0" value= <?php echo $medQuantity ?> oninput="validity.valid||(value='');" required>

                        <input type="hidden" name="uploadTime" id="dateTime" >
                        
                        <input type="submit" name="saveChanges"  class="btn btn-primary saveChangesBtn" value="Save Changes" data-bs-toggle="modal" data-bs-target="#myModal"/>
         
                </div>
            </form>

            
        </div>
    </div>


    <?php 
    
    if (isset($_SESSION['success'])) {

        ?>

    <!-- Trigger/Open The Modal -->

<!-- The Modal -->
<div id="myModal" class="modal" >

  <!-- Modal content -->
  <div class="modal-content">
    
<!-- <div class="modal-body"> -->
<div >
    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    
    <img class="imgComplete mx-auto" src="assets/images/complete.svg">
    <p class="mx-auto success">Sucessfully updated</p>

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
    
    // if (isset($_SESSION['success'])) {
        unset($_SESSION['success']);
        }
        
 ?>

<script type="text/javascript">
        var d = new Date();

        // Set the value of the "time" field
        var hours = d.getHours();
        var mins = d.getMinutes();
        var seconds = d.getSeconds();
        document.getElementById("dateTime").value = d.toDateString() + " " + hours + ":" + mins;
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>
</html>