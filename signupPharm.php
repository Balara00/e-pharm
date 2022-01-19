<?php
//include('includes/signupCus.inc.php');
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = "";
    $deliveryOrders = "";
}
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
} else {
    $name = "";
}
if (isset($_SESSION['address'])) {
    $address = $_SESSION['address'];
} else {
    $address = "";
}
if (isset($_SESSION['contactNo'])) {
    $contactNo = $_SESSION['contactNo'];
} else {
    $contactNo = "";
}
if (isset($_SESSION['area'])) {
    $area = $_SESSION['area'];
} else {
    $area = "";
}
if (isset($_SESSION['dvOrders'])) {
    $dvOrders = $_SESSION['dvOrders'];
} else {
    $dvOrders = "";
}

if (!isset($_SESSION['errors'])) {
    $_SESSION['errors'] = array();
}
if (!isset($_SESSION['dvStatus'])) {
    $_SESSION['dvStatus'] = '0';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style_temp.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>Sign up page</title>
</head>

<body>
    <div class="center_bg">
        <h2 id="e-pharm">E-Pharm</h2>
        <div class="sign-form">
            <div class="welcome-containerP">
                <h3 id="welcomeP">Welcome!</h3>
            </div>
            <?php
            if (isset($_SESSION['mailError'])) {
                echo ('<p style="color:red;
                font: size 15px;
                text-align: center;
                font-family: Ubuntu;

                ">' . htmlentities($_SESSION['mailError']) . "</p>\n");
                unset($_SESSION['mailError']);
            }
            ?>
            <div class="form-container">
                <form method="post" action="includes/signUpPharm.inc.php">
                    <div class="input-group" id="field_1">
                        <img src="icons/user.svg" alt="">
                        <input type="text" name="name" placeholder="Pharmacy Name" value="<?php echo $name; ?>" onfocus="change_color('field_1')">
                        <?php if (in_array("Name is required", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Pharmacy name is required</p>
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
                    <div class="bet-inputs"></div>
                    <div class="input-group" id="field_2">
                        <img src="icons/user.svg" alt="">
                        <input type="email" name="username" placeholder="Username (Email Address)" value="<?php echo $username; ?>" onfocus="change_color('field_2')">
                        <?php if (in_array("Username is required", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Username is required</p>
                            <style>
                                #field_2 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                        <?php if (in_array("Username already exists", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Username already exists</p>
                            <style>
                                #field_2 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px red;
                                }
                            </style>
                        <?php endif ?>
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="input-group" id="field_5">
                        <img src="icons/user.svg" alt="">
                        <input type="number" name="contactNo" oninput="validity.valid||(value='')" placeholder="Contact Number" value="<?php echo $contactNo; ?>" onfocus="change_color('field_5')">
                        <?php if (in_array("Contact number is required", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Contact Number is required</p>
                            <style>
                                #field_5 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                        <?php if (in_array("Invalid contact number", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Invalid contact number</p>
                            <style>
                                #field_5 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="input-group" id="field_6">
                        <img src="icons/user.svg" alt="">
                        <input type="text" name="address" placeholder="Address" value="<?php echo $address; ?>" onfocus="change_color('field_6')">
                        <?php if (in_array("Address is required", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Address is required</p>
                            <style>
                                #field_6 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="input-group" id="field_7">
                        <img src="icons/user.svg" alt="">
                        <input type="text" name="area" placeholder="Area" value="<?php echo $area; ?>" onfocus="change_color('field_7')">
                        <?php if (in_array("Area is required", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Area is required</p>
                            <style>
                                #field_7 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="input-groupP">
                        <label for="myCheck">
                            <p class="isAvbTxt">Is delivery services available?</p>
                        </label>
                        <input type="checkbox" name="dvStatus" id="myCheck" onclick="myFunction()">
                        <!-- <input type="number" name="name" placeholder="Number of delivery orders per day" value=""> -->
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="input-group" id="field_8" style="display:none;border: 2px solid #4186ff;border-radius: 20px;">
                        <img src="icons/user.svg" alt="">
                        <input type="number" name="dvOrders" oninput="validity.valid||(value='')" placeholder="Number of delivery orders per day" value="<?php echo $dvOrders; ?>" onfocus="change_color('field_8')">
                        <?php if (in_array("Number is required", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Number of delivery orders is required</p>
                            <style>
                                #field_8 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="input-group" id="field_3">
                        <img src="icons/password.svg" alt="">
                        <input type="password" placeholder="Password" name="password_1" onfocus="change_color('field_3')">
                        <?php if (in_array("Password is required", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Password is required</p>
                            <style>
                                #field_4,
                                #field_3 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                        <?php if (in_array("Password must be at least 6 charactors long", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">Password must be at least 6 charactors long</p>
                            <style>
                                #field_3,
                                #field_4 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                        <?php if (in_array("The two passwords do not match", $_SESSION['errors'])) : ?>
                            <p class="tooltiptext">The two passwords do not match</p>
                            <style>
                                #field_3,
                                #field_4 {
                                    border-color: #cc3c31;
                                    -moz-box-shadow: 0 0 3px red;
                                    -webkit-box-shadow: 0 0 3px red;
                                    box-shadow: 0 0 3px #333 red;
                                }
                            </style>
                        <?php endif ?>
                        <?php unset($_SESSION['errors']); ?>
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="input-group" id="field_4">
                        <img src="icons/password.svg" alt="">
                        <input type="password" placeholder="Confirm Password" name="password_2" onfocus="change_color('field_4')">
                    </div>
                    <div class="bet-inputs"></div>
                    <div class="signup-btn">
                        <button type="submit" class="btn" name="reg_user">Sign Up</button>
                    </div>
                    <div class="login-askP">
                        <p>
                            Already have an account? <a id="log-link" href="login.php">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($_SESSION['dvStatus'] == '1') {
    ?>
        <script>
            var checkBox = document.getElementById("myCheck");
            var text = document.getElementById("field_8");
            checkBox.checked = true;
            text.style.display = "block";
        </script>
    <?php
    }
    ?>

    <script>
        function change_color(x) {
            document.getElementById(x).style.borderColor = "rgb(65, 134, 255)";
            document.getElementById(x).style.boxShadow = "none";
        }
    </script>
    <script>
        function myFunction() {
            var checkBox = document.getElementById("myCheck");
            var text = document.getElementById("field_8");
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
    </script>

</body>