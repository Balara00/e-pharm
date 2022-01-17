<?php
session_start();
include "classes/dbconnection.classes.php";
include "model/cartModel.php";
include "classes/Cart.classes.php";
include "classes/pharmacy_medicine.classes.php";
include "classes/Medicine.classes.php";
include "classes/Pharmacy.classes.php";
include "classes/Pharmacy_.classes.php";
include "controller/controller.php";
include "controller/cartContr.php";
include "view/cartView.php";

$_SESSION['customerID'] = 24;

$cartView = new CartView();

$cart = $cartView->showCart($_SESSION['customerID']);

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
    <link rel="stylesheet" href="assets/css/cart.css">
    <title>Cart</title>
</head>

<body class="index_body">
    <div class="container">
        <div class="nav-bar"></div>
        <div class="cart-all">
            <div class="cart-topic">
                <p>Cart</p>
            </div>
            <?php
            $idCount = 0;
            foreach ($cart as $pharmID => $medList) {
                $buyNw = true;
                $idCount++;
                $pharmacy = $cartView->getPharm($pharmID);
                $subtot = 0;
                $medArray = array();
                $canBuyNow = $cartView->canBuyNow($pharmacy->getdvStatus(), $pharmacy->getdvOrders(), $pharmID);
            ?>
                <div class="pharmacy">
                    <div class="pharmacy-name">
                        <p><?php echo $pharmacy->getName() ?> - <?php echo $pharmacy->getArea() ?></p>
                    </div>
                    <div class="medicine-list">
                        <table class="med-list">
                            <?php
                            foreach ($medList as $medDetail) {
                                $pharmMed = $cartView->getPharmMed($pharmID, $medDetail[0]);
                                $medicine = $cartView->getMed($medDetail[0]);
                                $medArray[$medDetail[0]] = $medDetail[1];
                            ?>
                                <tr class="row-med">
                                    <td class="td1"><img class="med-img" src="uploads/<?php echo $pharmMed->getMedURL() ?>"></td>
                                    <td class="td2">
                                        <h class="drug-name"><?php echo $medicine->getName() ?></h><br>
                                        <h class="drug-price">Rs.<?php echo $pharmMed->getPrice() ?></h><br>
                                        <form method="post" action="includes/cart.inc.php">
                                            <?php
                                            if ($medDetail[1] > $pharmMed->getAmount()) {
                                                $buyNw = false;
                                            ?>
                                                <input type="number" name="quantityTxt" min="1" max=<?php echo $medDetail[1] ?> required onKeyDown="return false" value=<?php echo $medDetail[1] ?>>
                                                <p class="stock-exceeded">Required amount is out of stock<br>Available amount : <?php echo $pharmMed->getAmount() ?></p>
                                            <?php
                                            } else {
                                            ?>
                                                <input type="number" name="quantityTxt" min="1" max=<?php echo $pharmMed->getAmount() ?> required onKeyDown="return false" value=<?php echo $medDetail[1] ?>>
                                            <?php
                                            }
                                            ?>
                                    </td>
                                    <!-- <td><button type="submit" class="btn" name="reg_user">Sign Up</button></td> -->
                                    <input type="hidden" name="amount" value=<?php echo $medDetail[1] ?> />
                                    <input type="hidden" name="pharmID" value=<?php echo $pharmID ?> />
                                    <input type="hidden" name="medID" value="<?php echo $medDetail[0] ?>" />
                                    <td class="td3"><br><br><br><input type="submit" name="saveChanges" class="saveChangesBtn" value="Save Changes" data-bs-toggle="modal" data-bs-target="#myModal" /></td>
                                    <td class="td4"><input type="image" name="dlt" src="icons/delete.svg" /><br>
                                        </form>
                                        <h class="drug-price">Rs.<?php echo number_format((float)$pharmMed->getPrice() * (float)$medDetail[1], 2) ?></h>
                                        <?Php $subtot = $subtot + (float)$pharmMed->getPrice() * (float)$medDetail[1] ?>
                                    </td>

                                    </td>
                                </tr>
                                <tr class='between-row'></tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="order-summry">
                        <div class="summ-text">
                            <p class="summ-text">Order Summary</p>
                        </div>
                        <div class="summ-content">
                            <p><b>Sub Total &emsp;</b> Rs.<?php echo number_format($subtot, 2) ?></p>
                            <form method="post" action="includes/cart.inc.php">
                                <input type="hidden" name="pharmID" value=<?php echo $pharmID ?> />
                                <input type="hidden" name="medQuantityArr" value=<?php echo htmlentities(serialize($medArray)); ?> />
                                <div class='note'>
                                    <?php
                                    if ($canBuyNow != 'enable') {
                                    ?>
                                        <p><?php echo $canBuyNow ?></p>

                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($canBuyNow != 'enable' or !$buyNw) {
                                ?>
                                    <input type="submit" class='btns' name="buyNow" value="Buy Now" id="item_<?php echo $idCount ?>" disabled />
                                <?php
                                } else {
                                ?>
                                    <input type="submit" class='btns' name="buyNow" value="Buy Now" id="item_<?php echo $idCount ?>" />
                                <?php
                                }
                                ?>
                                <br>
                                <?php
                                if (!$buyNw) {
                                ?>
                                    <input type="submit" class='btns' name="reserveNow" value="Reserve Now" disabled />
                                <?php
                                } else {
                                ?>
                                    <input type="submit" class='btns' name="reserveNow" value="Reserve Now" />
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>

    <?php
    if (isset($_SESSION['success'])) {
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

                <img class="imgCart mx-auto" src="assets/images/cart.svg">
                <p class="mx-auto success">Sucessfully updated</p>

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
        unset($_SESSION['success']);
    }
    ?>
    <?php if (isset($_SESSION['successDlt'])) { ?>
        <p>ff</p>
        <!-- Trigger/Open The Modal -->

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">

                <div>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <img class="imgCart mx-auto" src="assets/images/cart.svg">
                <p class="mx-auto success">Are you sure you want to delete this item from cart?</p>

                <?php
                echo '<a class="btn btn-primary viewCartBtn mx-auto" name ="yes" href="includes/cart.inc.php?status=yes" role="button">Yes</a>';
                echo '<a class="btn btn-primary viewCartBtn mx-auto" name ="no" href="includes/cart.inc.php?status=no" role="button">No</a>';
                ?>
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
        unset($_SESSION['successDlt']);
    }

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>