<?php
//include('includes/signupCus.inc.php');
session_start();
// $_SESSION['customerID'] = 24;
// $_SESSION['pharmacyID'] = 1;
if (isset($_SESSION['medname'])) {
    $name = $_SESSION['medname'];
} else {
    $name = "";
}
if (isset($_SESSION['price'])) {
    $price = $_SESSION['price'];
} else {
    $price = "";
}
if (isset($_SESSION['amount'])) {
    $amount = $_SESSION['amount'];
} else {
    $amount = "";
}
if (!isset($_SESSION['errors'])) {
    $_SESSION['errors'] = array();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link rel="stylesheet" type="text/css" href="assets/css/addMed.css">
    <title>Add Medicine</title>
</head>
<?php 
    include "classes/dbconnection.classes.php";
?>
<body>

    <body class="index_body">
        <div class="container">
            <?php include "Controller/controller.php" ?>
            <?php include "navBar_pharmacy.php" ?>
            <div class="sign-form">
                <div class="welcome-container">
                    <h3 id="welcome">Add Medicine</h3>
                </div>
                <div class="form-container">
                    <form method="post" action="includes/addMed.inc.php" enctype="multipart/form-data">
                        <div class='oneline'>
                            <p class="txtt">Name of the Medicine</p>
                            <div class="input-group" id="field_1">
                                <!-- <img src="icons/user.svg" alt=""> -->
                                <input type="text" name="name" value="<?php echo $name; ?>" onfocus="change_color('field_1')">
                                <?php if (in_array("Medicine name is required", $_SESSION['errors'])) : ?>
                                    <p class="tooltiptext">Name is required</p>
                                    <style>
                                        #field_1 {
                                            border-color: #cc3c31;
                                            -moz-box-shadow: 0 0 3px red;
                                            -webkit-box-shadow: 0 0 3px red;
                                            box-shadow: 0 0 3px #333 red;
                                        }
                                    </style>
                                <?php endif ?>
                                <?php if (in_array("Medicine is already exists", $_SESSION['errors'])) : ?>
                                    <p class="tooltiptext">Medicine is already exists</p>
                                    <style>
                                        #field_1 {
                                            border-color: #cc3c31;
                                            -moz-box-shadow: 0 0 3px red;
                                            -webkit-box-shadow: 0 0 3px red;
                                            box-shadow: 0 0 3px #333 red;
                                        }
                                    </style>
                                <?php endif ?>

                            </div>
                        </div>
                        <div class="between-inputs"></div>
                        <div class='oneline'>
                            <p class="txtt">Unit Price (Rs.)</p>
                            <div class="input-group" id="field_2">
                                <!-- <img src="icons/user.svg" alt=""> -->
                                <input type="number" name="price" oninput="validity.valid||(value='')" step="any" value="<?php echo $price; ?>" onfocus="change_color('field_2')">
                                <?php if (in_array("Price is required", $_SESSION['errors'])) : ?>
                                    <p class="tooltiptext">Price is required</p>
                                    <style>
                                        #field_2 {
                                            border-color: #cc3c31;
                                            -moz-box-shadow: 0 0 3px red;
                                            -webkit-box-shadow: 0 0 3px red;
                                            box-shadow: 0 0 3px #333 red;
                                        }
                                    </style>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="between-inputs"></div>
                        <div class='oneline'>
                            <p class="txtt">Quantity</p>
                            <div class="input-group" id="field_3">
                                <!-- <img src="icons/password.svg" alt=""> -->
                                <input type="number" oninput="validity.valid||(value='')" value="<?php echo $amount; ?>" name="amount" onfocus="change_color('field_3')">
                                <?php if (in_array("Quantity is required", $_SESSION['errors'])) : ?>
                                    <p class="tooltiptext">Quantity is required</p>
                                    <style>
                                        #field_3 {
                                            border-color: #cc3c31;
                                            -moz-box-shadow: 0 0 3px red;
                                            -webkit-box-shadow: 0 0 3px red;
                                            box-shadow: 0 0 3px #333 red;
                                        }
                                    </style>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="between-inputs"></div>
                        <div class="input-file" id="field_4">
                            <div class='oneline'>
                                <label for="fileToUpload" class="txtt">Image of Medicine </label>
                                <input type="file" name="uploadFile" id="fileToUpload" required aria-describedby="acceptedFilesBlock" accept=".png, .jpg, .jpeg"><br>
                            </div>
                            <small id="acceptedFilesBlock" class="form-text text-muted">(Only jpg, jpeg and png file types are accepted.)
                            </small>

                            <!-- <input type="password" placeholder="Confirm Password" name="password_2" onfocus="change_color('field_4')"> -->
                        </div>
                        <div class="between-inputs"></div>
                        <div class="signup-btn">
                            <!-- <td class="td3"><br><br><br><input type="submit" name="saveChanges" class="saveChangesBtn" value="Save Changes" data-bs-toggle="modal" data-bs-target="#myModal" /></td> -->
                            <button type="submit" class="btn btn-primary" name="add_med" data-bs-toggle="modal" data-bs-target="#myModal">Add</button>
                        </div>
                    </form>
                    <form method="post" action="includes/addMed.inc.php">
                        <div class="back-btn">
                            <!-- <td class="td3"><br><br><br><input type="submit" name="saveChanges" class="saveChangesBtn" value="Save Changes" data-bs-toggle="modal" data-bs-target="#myModal" /></td> -->
                            <button type="submit" class="btn btn-primary" name="back">Back to Store</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        if (isset($_SESSION['successAdd'])) {
        ?>
            <!-- Trigger/Open The Modal -->

            <!-- The Modal -->
            <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">

                    <!-- <div class="modal-body"> -->
                    <div>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <img class="imgCart mx-auto" src="assets/images/complete.svg">
                    <p class="mx-auto success">Successfully added to the store</p>

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
            unset($_SESSION['successAdd']);
        }
        ?>


        <script>
            function change_color(x) {
                document.getElementById(x).style.borderColor = "rgb(65, 134, 255)";
                document.getElementById(x).style.boxShadow = "none";
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>