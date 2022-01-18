<?php
//include('includes/signupCus.inc.php');
session_start();

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
    <link rel="stylesheet" type="text/css" href="assets/css/addMed.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>Add Medicine</title>
</head>

<body>

    <body class="index_body">
        <div class="container">

        <?php 
        include "classes/dbconnection.classes.php";
        include "Controller/controller.php";
        include "navBar_pharmacy.php";
        ?>

            <div class="sign-form">
                <div class="welcome-container">
                    <h3 id="welcome">Add Medicine</h3>
                </div>
                <div class="form-container">
                    <form method="post" action="includes/addMed.inc.php" enctype="multipart/form-data">
                        <div class="input-group" id="field_1">
                            <img src="icons/user.svg" alt="">
                            <input type="text" name="name" placeholder="Medicine Name" value="<?php echo $name; ?>" onfocus="change_color('field_1')">
                            <?php if (in_array("Medicine name is required", $_SESSION['errors'])) : ?>
                                <p class="tooltiptext">Medicine name is required</p>
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
                        <div class="between-inputs"></div>
                        <div class="input-group" id="field_2">
                            <img src="icons/user.svg" alt="">
                            <input type="number" name="price" oninput="validity.valid||(value='')" placeholder="Unit price (Rs.)" value="<?php echo $price; ?>" onfocus="change_color('field_2')">
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
                        <div class="between-inputs"></div>
                        <div class="input-group" id="field_3">
                            <img src="icons/password.svg" alt="">
                            <input type="number" placeholder="Quantity" oninput="validity.valid||(value='')" value="<?php echo $amount; ?>" name="amount" onfocus="change_color('field_3')">
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
                        <div class="between-inputs"></div>
                        <div class="input-file" id="field_4">
                            Image of medicine
                            <input type="file" name="uploadFile" id="fileToUpload" required aria-describedby="acceptedFilesBlock" accept=".png, .jpg, .jpeg">
                            <small id="acceptedFilesBlock" class="form-text text-muted">(Only jpg, jpeg and png file types are accepted.)
                            </small>

                            <!-- <input type="password" placeholder="Confirm Password" name="password_2" onfocus="change_color('field_4')"> -->
                        </div>
                        <div class="between-inputs"></div>
                        <div class="signup-btn">
                            <button type="submit" class="btn" name="add_med">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function change_color(x) {
                document.getElementById(x).style.borderColor = "rgb(65, 134, 255)";
                document.getElementById(x).style.boxShadow = "none";
            }
        </script>

    </body>