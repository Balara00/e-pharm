<?php
    session_start();
    require_once "pdo.php";


    if (!isset($_GET['customerID']) || !isset($_GET['pharmacyID']) || !isset($_GET['medID'])) {
        die("ACCESS DENIED");
    }

    $stmt = $pdo -> prepare("SELECT * FROM customer WHERE customerID = :xyz");
    $stmt -> execute(array(":xyz" => $_GET['customerID']));
    $pharmacyDet = $stmt -> fetch(PDO::FETCH_ASSOC);   

    if ($pharmacyDet === false) {
        $_SESSION['error'] = "Can't find data record in database table course.";
        header("Location: index.php");
    }
    

    $stmt = $pdo -> prepare("SELECT `name`, `area` FROM pharmacy WHERE pharmacyID = :xyz");
    $stmt -> execute(array(":xyz" => $_GET['pharmacyID']));
    $pharmacyDet = $stmt -> fetch(PDO::FETCH_ASSOC);   

    if ($pharmacyDet === false) {
        $_SESSION['error'] = "Can't find data record in database table course.";
        header("Location: index.php");
    }
    
    $stmt = $pdo -> prepare("SELECT `name`, `price` FROM medicine WHERE medID = :abc");
    $stmt -> execute(array(":abc" => $_GET['medID']));
    $medDet = $stmt -> fetch(PDO::FETCH_ASSOC);  

    if ($medDet === false) {
        $_SESSION['error'] = "Can't find data record in database table course.";
        header("Location: index.php");
    }

    $stmt = $pdo -> prepare("SELECT * FROM pharmacy_medicine WHERE pharmacyID = :xyz AND medID = :abc");
    $stmt -> execute(array(":xyz" => $_GET['pharmacyID'], ":abc" => $_GET['medID']));
    $pharm_medDet = $stmt -> fetch(PDO::FETCH_ASSOC);  


    $pharmacyID = $pharm_medDet['pharmacyID'];
    $medID = $pharm_medDet['medID'];
    $customerID = $_GET['customerID'];
    $quantity = $pharm_medDet['amount'];


    if (isset($_POST['buyNow']) || isset($_POST['addToCart'])) {

        if (isset($_POST['buyNow'])) {
            header("Location: payment.php");
        }

        if(isset($_POST['addToCart'])) {
            $stmt = $pdo -> prepare("SELECT * FROM `cart` WHERE customerID = :customerID AND pharmacyID = :pharmacyID  AND medID = :medID");
            $stmt -> execute(array(":customerID" => $customerID, ":pharmacyID" => $pharmacyID, ":medID" => $medID));
            $cartDet = $stmt -> fetch(PDO::FETCH_ASSOC);  
        
            if (!$cartDet === false) {
                $sql = "UPDATE `cart` SET `amount` = :amount WHERE `customerID` = :customerID AND `pharmacyID` = :pharmacyID  AND `medID` = :medID";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute(array(
                    ':amount' => $_POST['quantityTxt'] + $cartDet['amount'],
                    ':customerID' => $_POST['customerID'],
                    ':pharmacyID' => $_POST['pharmacyID'],
                    ':medID' => $_POST['medID'],
                ));
                        
                $_SESSION['success'] = "Record updated";
                header("Location: cart.php?customerID=".$customerID);
                return;

            } else {
                $sql = "INSERT INTO cart (customerID, medID, pharmacyID, amount) VALUES (:customerID, :medID, :pharmacyID, :amount)";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute(array(
                    ':customerID' => $_POST['customerID'],
                    ':medID' => $_POST['medID'], 
                    ':pharmacyID' => $_POST['pharmacyID'],
                    ':amount' => $_POST['quantityTxt']
                ));
                $_SESSION['success'] = "Record added";
                header("Location: cart.php?customerID=".$customerID);
                return;
            }
        }
        
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/viewMed.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    
    <title>Document</title>
</head>
<body class="viewMed_body">

    <?php
        if(isset($_SESSION['get'])) {
            header("Location: viewMed.php?customerID=".$customerID."&medID=".$medID."&pharmacyID=".$pharmacyID);
            unset($_SESSION['get']);
            return;
        }

        if(isset($_SESSION['error'])) {
            echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>

    <div class="viewMed_container">

        <nav class="navbar navbar-light navbar_ePharm">
            <div class="container-fluid">
                <a class="navbar-brand navbarTitle" href="index.php">E-Pharm</a>
                <a class="btn btn-primary logoutBtn" href="logout.php">Logout</a>
            </div>
        </nav>
    
        <?php
            echo '<img class="imgMed" src="uploads/'.$pharm_medDet['medURL'].'">';
        
                
            echo '<form action="" method="post">';

            echo '<input type="hidden" name="customerID" value="'.$customerID.'">'."\n"; 
            echo '<input type="hidden" name="pharmacyID" value="'.$pharm_medDet['pharmacyID'].'">'."\n"; 
            echo '<input type="hidden" name="medID" value="'.$pharm_medDet['medID'].'">'."\n"; 
            ?>
  
            <div class="medDetails">
                <div class="stripe"> </div>
                <div class="pharmacy">
                    <?php echo ($pharmacyDet['name']. " - ". $pharmacyDet['area']); ?>
                </div>

                <?php echo '<a class="btn btn-secondary viewPharmacyBtn" href="pharmacy.php?pharmacyID='.$pharmacyID.'">View Pharmacy</a>';?>
            
                <div class="medicine">
                    <?php echo $medDet['name'] ;?>
                </div>
            
                <div class="price">
                    <?php echo "Rs.".$medDet['price'];?>
                </div>
            
                <div class="quantity">
                    <?php
                        $showQuantity = $quantity;
                        if ($quantity == "0") {
                            echo '<p class="outOfStock">Out of Stock</p>';
                            echo '<input type="submit" name="buyNow" class="btn buyNowBtn" value="Buy Now" disabled/>';
                            echo '<input type="submit" name="addToCart" class="btn addToCartBtn" value="Add to Cart" disabled/>';

                        }else{
                            echo '<p class="quantityTxt">Quantity</p>';
                            echo '<input type="number" id="quantityTxtBox" name="quantityTxt" min="1" max="'.$quantity.'" required onKeyDown="return false" value="1">';
                            
                        //variables/////////////////////////////////////////
                            echo '<input type="submit" name="buyNow" class="btn btn-primary buyNowBtn" value="Buy Now"/>';
                            echo '<input type="submit" name="addToCart" class="btn btn-danger addToCartBtn" value="Add to Cart" data-bs-toggle="modal" data-bs-target="#staticBackdrop"/>';

                           
                    ?>
                </div>
            </form>

        </div>
    </div>

    <?php 

        } ?>

</body>
</html>