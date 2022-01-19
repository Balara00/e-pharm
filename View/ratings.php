<?php
session_start();
 $customerID=$_GET['customerID'];
 $pharmacyID = $_GET['pharmacyID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/ratings.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
       <div class="star-widget">
       <form action ="../includes/ratings.php?customerID=<?= $customerID?>&pharmacyID=<?= $pharmacyID?>" method="POST">
            <p id="head">Rate our pharmacy</p>
           <input type ="radio" name="rate" id="rate-5" value="5">
           <label for="rate-5" class="fas fa-star"></label>
           <input type ="radio" name="rate" id="rate-4" value="4">
           <label for="rate-4" class="fas fa-star"></label>
           <input type ="radio" name="rate" id="rate-3" value="3">
           <label for="rate-3" class="fas fa-star"></label>
           <input type ="radio" name="rate" id="rate-2" value="2">
           <label for="rate-2" class="fas fa-star"></label>
           <input type ="radio" name="rate" id="rate-1" value="1">
           <label for="rate-1" class="fas fa-star"></label>
           <section>
                <header></header>
                
                <div class="btn">
                    <button type ="submit" name="ratingsBtn" type="submit">Post</button>
                </div>
                
            </section>
        </form>
       </div> 
    </div>
</body>
</html>