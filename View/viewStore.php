<?php session_start(); 
include "../Controller/viewStore_contr.php";
$pharmacyID=1005;
$viewPharmacyContr = new ViewStoreContr($pharmacyID); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/stylesViewStore.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Store</title>
</head>
<body>
    <div class="all"></div>
    
    <div class="navlanding">
            
            <a href="notification.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><img class="imgs bask" src="../assets/icons/notification.svg"></a>
            
            <a href="user.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><img class="imgs bask" src="../assets/icons/user.svg"></a>
            
            <a href="logout.php?pharmacyID="<?=$_SESSION['pharmacyID']?>><button name="logOut" id="logout" class="butn log" type="submit">Logout</button></a>
            
    </div>
    <?php
    $rating=$viewPharmacyContr->getRatings($pharmacyID); ?>
    <div class="user-rating">
        <p class="ratingTitle">Average user ratings</p><br>
        <p class="ratingvalue"><?= $rating['averageRating']?>/5 (from <?= $rating['noOfReviews']?> reviews)</p>
        <div class="container-star">
        <div class="star-widget">
            
            <label id="star1" for="rate-1" class="fas fa-star"></label>
            
            <label id="star2" for="rate-2" class="fas fa-star"></label>
            
            <label id="star3" for="rate-3" class="fas fa-star "></label>
            
            <label id="star4" for="rate-4" class="fas fa-star"></label>
            
            <label id="star5" for="rate-5" class="fas fa-star"></label>
        </div> 
        </div>
    </div>

    <script>
        function star(i){
            for(let j=1; j<(i+1);j++){
                document.getElementById("star"+j).classList.add("active");
            }
        }

    </script>


    </div>

    <?php 
        $pharmacy= $viewPharmacyContr->searchPharmacy($pharmacyID);
    ?>
        <header class="epharm">E-Pharm</header>
        <header class="pharmacy"><?=$pharmacy['name']?> - <?=$pharmacy['area']?></header>

        
        <form id="Form" action="viewPharmacy.php" method="get">
            <div class="wrap">
                <div class="search">

                    <input name="search" id="searchTerm" type="text" class="searchTerm" placeholder="What are you looking for?">
                    <button name="find" type="submit" class="searchButton">Find</button>
                </div>
            </div>
        </form>

        <div class="stripe-menu">
            <div class="stripe"></div>
            <div class="vertical-menu">
                <a class="active" href="account.php?customerID="."$_SESSION['customerID']" class="a1">Store</a>
                <a id="a2"  class="a2">Pharmacy Profile</a>
                <a href="myPrescriptions.php" class="a3">My Prescriptions</a>
                <a class="a4">Orders</a>
                <a href="" class="a5">Prescriptions</a>
            </div>
        </div>

       <a href=""> <button class="plus"></button></a>
        <!-- <a href="addNew.php"><img src="../assets/images/editBtn.png" class="editImg"></a> -->
        

        <div class="orderType">
            <a class = "delivery delivery-pickup" href = "storeOrders.php?pharmacyID=<?= $pharmacyID;?>&<?= "type=delivery"?>" >Delivery</a>
            <a class = "pickup delivery-pickup" href="storeOrders.php?<?= "type=pickup"?>"">Pickup</a>
        </div>
    
        <div class="scroll-flow">
        <?php        
        
            if(isset($_GET['find']) ){
                
                $viewPharmacyContr->displaySearch(preg_replace('/[0-9\@\.\;\" "]+/', '', $_GET['search']));
            }else{
                
                $viewPharmacyContr->displayAllItems();
            }
            echo '<script> star('.floor($rating['averageRating']).');</script>';
            
        ?>
        </div>
      
    
</body>
</html>