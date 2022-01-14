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
    <link rel="stylesheet" href="assets/css/uploadPrescription.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    
    <title>Upload Prescription</title>
</head>
<body class="uploadPres_body">

    <?php
    include "classes/dbConnection.class.php";
    include "Model/pharmacy.model.php";
    include "classes/pharmacy.class.php";
    include "classes/notificationMediator.php";
    include "Model/uploadPrescription.model.php"; 
    include "Controller/uploadPrescription.contr.php";
    include "View/uploadPrescription.view.php";

    $uploadPresc_view = new UploadPrescriptionView();

    ////////////////////////////////
    $customerID = $_GET['customerID'];
    $_SESSION['customerID'] = $customerID;

        if(isset($_SESSION['get'])) {
            header("Location: uploadPrescription.php?customerID=".$customerID);
            unset($_SESSION['get']);
            return;
        }

        if(isset($_SESSION['error'])) {
            echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>

    <div class="uploadPres_container">
    
        <?php
        include "navBar.php";

        echo '<form action="includes/uploadPrescription.inc.php?customerID='.$customerID.'" method="post" enctype="multipart/form-data">'

        ?>
                <div class="pres_upload">
                    <p class="uploadPres_title">Upload Prescription</p>
                    <p class="uploadPres_decs">
                        Please upload an image of your medical prescription issued by a SLMC registered doctor
                    </p>
                    <div class="uploadPresc_area_box">                    
                        <label for="area" class="form-label uploadPresc_area">Area</label>
                    </div>

                    <select class="form-select uploadPresc_select" aria-label="Default select example" name="selectedArea" required>
                        <option value="">Select area</option>

                        <?php
                        $area_list = $uploadPresc_view->getAreaList();

                        foreach ($area_list as $area_i) {
                            echo '<option value="' .$area_i. '">' .$area_i. '</option>';
                        }

                        ?>
                    </select>


                    <label for="upload" class="form-label uploadPresc_txt">Upload Prescription Photo</label>
                    <input type="file" class="form-form-control-file uploadPresc_photo" name="prescPhoto" id="mypres" required aria-describedby="acceptedFilesBlock" accept=".png, .jpg, .jpeg"/>

                    <small id="acceptedFilesBlock" class="form-text text-muted">
                        (Only jpg, jpeg and png file types are accepted.)
                    </small>
                    <!-- <p>Only jpg, jpeg and png file types are accepted.</p> -->

                    <textarea name="prescNote" id="" cols="30" rows="10" class="form-control uploadPresc_note" placeholder="Special Notes..."></textarea>
                    <!-- <input type="text" class="form-control uploadPresc_note" name="prescNote" id="note" placeholder="Special Notes..."/> -->
                    <input type="hidden" name="uploadTime" id="dateTime" >

                    <input type="submit" name="uploadPresc" class="btn btn-primary uploadPrescBtn" value="Upload" data-bs-toggle="modal" data-bs-target="#myModal"/>

                </div>
              
            </form>

        </div>
    </div>

    <?php 
    
    if (isset($_SESSION['success'])) {

        ?>
        <!-- The Modal -->
        <div id="myModal" class="modal" >

        <!-- Modal content -->
        <div class="modal-content">
     
        <div >
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <img class="imgPrescription mx-auto" src="assets/images/prescription.svg">
            <p class="mx-auto success">Sucessfully updated</p>

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