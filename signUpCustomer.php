<?php include('server_.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style_temp.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>Sign up page</title>
</head>

<body>
    <div class="center_bg">
        <h2 id="e-pharm">E-Pharm</h2>
        <div class="sign-form">
            <div class="welcome-container">
                <h3 id="welcome">Welcome!</h3>
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
                <form method="post" action="signUpCustomer.php">
                    <div class="input-group" id="field_1">
                        <img src="icons/user.svg" alt="">
                        <input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>" onfocus="change_color('field_1')">
                        <?php if (in_array("Name is required", $errors)) : ?>
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
                    </div>
                    <div class="between-inputs"></div>
                    <div class="input-group" id="field_2">
                        <img src="icons/user.svg" alt="">
                        <input type="email" name="username" placeholder="Username (Email Address)" value="<?php echo $username; ?>" onfocus="change_color('field_2')">
                        <?php if (in_array("Username is required", $errors)) : ?>
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
                        <?php if (in_array("Username already exists", $errors)) : ?>
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
                    <div class="between-inputs"></div>
                    <div class="input-group" id="field_3">
                        <img src="icons/password.svg" alt="">
                        <input type="password" placeholder="Password" name="password_1" onfocus="change_color('field_3')">
                        <?php if (in_array("Password is required", $errors)) : ?>
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
                        <?php if (in_array("Password must be at least 6 charactors long", $errors)) : ?>
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
                        <?php if (in_array("The two passwords do not match", $errors)) : ?>
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
                    </div>
                    <div class="between-inputs"></div>
                    <div class="input-group" id="field_4">
                        <img src="icons/password.svg" alt="">
                        <input type="password" placeholder="Confirm Password" name="password_2" onfocus="change_color('field_4')">
                    </div>
                    <div class="between-inputs"></div>
                    <div class="signup-btn">
                        <button type="submit" class="btn" name="reg_user">Sign Up</button>
                    </div>
                    <div class="login-ask">
                        <p>
                            Already have an account? <a id="log-link" href="login.php">Login</a>
                        </p>
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