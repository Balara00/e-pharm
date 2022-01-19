<?php session_start();

$pharmacyID=$_GET['pharmacyID'];
include "../Controller/viewPharmacy_contr.php";
$viewPharmacyContr = new ViewPharmacyContr($pharmacyID);

include "../Model/navBar.model.php"; 
include "../Controller/navBar.contr.php";
$navbarContr = new NavBarContr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../assets/bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/stylesViewPharmacy.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pharmacy</title>
</head>
<body>
    <div class="all"></div>
    
    <div class="navlanding">
        <a href="landing.php?customerID=<?php $_SESSION['customerID'] ?>"><img class="imgs bask" src="../assets/icons/search.svg"></a>
        <a href="../notification.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/notification.svg"></a>
        <?php 
            $notificationNo = $navbarContr->getCustomerNotificationNo($_SESSION['customerID']);
            if ($notificationNo != 0) {

                echo '<p class="notificationNo">'.$notificationNo.'</p>';
            
            }
            ?>
        <a href="../cart.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/cart.svg"></a>

        <a href="../account.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/user.svg"></a>
        <a href=""><button name="addPrescription" id="addPres" class="butn pres" type="submit">Add Prescription</button></a>


        <a href="../logout.php?customerID=<?=$_SESSION['customerID']?>"><button name="logOut" id="logout" class="butn log" type="submit">Logout</button></a>
        


    </div>
    <?php 
        $pharmacy= $viewPharmacyContr->searchPharmacy($pharmacyID);
    ?>
        <header class="epharm">E-Pharm</header>
        <header class="pharmacy"><?=$pharmacy['name']?> - <?=$pharmacy['area']?></header>
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



    
        
        <form id="Form" action="viewPharmacy.php" method="get">
            <div class="wrap">
                <div class="search">

                    <input name="search" id="searchTerm" type="text" class="searchTerm" placeholder="What are you looking for?">
                    <button name="find" type="submit" class="searchButton">Find</button>


                </div>
            </div>
        </form>
        
    
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
    <div class="container-1">
        <div class="stripe stripe-1"></div>
        <div class="pharmacy-details">
            <p class="title">Contact Number</p>
            <p>0<?=$pharmacy['contact']?></p>
            <p class="title">Address</p>
            <p><?=$pharmacy['address']?></p>
            <p class="title">Email</p>
            <p>wdad@gmail.com</p>

        </div>
        <div class="stripe stripe-2"></div>
    </div>    

    
    
    
</body>
</html>