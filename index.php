<?php
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>E-Pharm</title>
</head>
<body class="index_body">
    <div class="container">
        
        <p class="title_ePharm text_index">E-Pharm</p>

        <p class="desc_ePharm text_index">Get your medicines with just one click</p>

        <p class="forCustomers text_index">For Customers</p>

        <p class="forPharmacies text_index">For Pharmacies</p>
        
        <button onclick="document.location = 'login.php' " class="btn btn-primary loginBtnNav"><p class="landBtnText">Login</p></button>
        <!-- <button class="btn btn-primary signUpBtnNav" disabled><p class="landBtnText">Sign Up</p></button> -->

        <button onclick="document.location = 'signupCus.php' " class="btn btn-primary signUpBtn customerSignUpBtn"> <p class="signUpBtnText"> Sign Up</br>& Order</p> </button>
        <button onclick="document.location = 'signupPharm.php' " class="btn btn-primary signUpBtn pharmacySignUpBtn"> <p class="signUpBtnText"> Register</br>Your Pharmacy</p> </button>
            
    </div>
</body>
</html>
