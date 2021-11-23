<?php
include("connection.php");
session_start();
?>

<!DOCTYPE html>
<?php include('connection.php'); ?>
<html lang="en">

<head>
    
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/stylesResults.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <img class="back" src="background.svg">
    <div class="sub">
        <div class="navlanding">

            <a href="cart.php"><img class="imgs bask" src="basket.svg"></a>

            <button name="addPrescription" id="addPres" class="butn pres" type="submit">Add Prescription</button>
            <script type="text/javascript">
                document.getElementById("addPres").onclick = function() {
                    location.href = "www.yoursite.com";
                };
            </script>

            <a href="logout.php"><img class="imgs logo" src="logo.svg"></a>

            <button name="logOut" id="logout" class="butn log" type="submit">Logout</button>
            <script type="text/javascript">
                document.getElementById("logout").onclick = function() {
                    location.href = "www.yoursite.com";
                };
            </script>


        </div>
        <header>E-Pharm</header>

        <img class="two" src="assets/images/2.png">
        <img class="one" src="assets/images/1.png">
        <form id="Form" action="results.php" method="get">
            <div class="wrap">
                <div class="search">

                    <input name="search" id="searchTerm" type="text" class="searchTerm" placeholder="What are you looking for?">
                    <button name="find" type="submit" class="searchButton">Find</button>


                </div>
            </div>
            <select name="area" class="area">
                <option value="Area">Area</option>
                <option value="colombo">Colombo</option>
                <option value="Kuliyapitiya">Kuliyapitiya</option>
                <option value="Matara">Matara</option>
            </select>
        </form>
        <script>
            const form = document.getElementById('Form');
            form.addEventListener('submit', (e) => {
                if (document.getElementById("searchTerm").value.length == 0) {
                    e.preventDefault();
                }

            });
        </script>
        <?php

        if (isset($_GET['find'])) {
            if (!empty($_GET['search'])) {
                $area = $_GET['area'];
                if ($area != 'Area') {
                    $searchq = $_GET['search'];
                    $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);
                    $medID;
                    $medPrice;
                    $customerID = $_SESSION['customerID'];
                    $pharmacyIDs = array();

                    $pharmacyID_pharmacy;
                    $query1 = mysqli_query($connection, "SELECT * FROM medicine WHERE name LIKE '%$searchq%'") or die("could not search");

                    $count = mysqli_num_rows($query1);
                    if ($count == 0) {

                        echo '<div class="search-results"  >Search results for: ' . $searchq . '</div>';
                        echo '<div class="no-results">
                            <p id="results">Your search returned no results.</p>
                            <p id="tips">Search Tips</p>
                            <li>Double check your spelling</li>
                            <li>Try using separate words</li>
                            <li>Try searching for an item that is less specific</li>
                            
                            </div>';
                        die;
                    } else {
                        $row = mysqli_fetch_array($query1);
                        $medID = $row['medID'];
                        $medPrice = $row['price'];
                    }

                    $query2 = mysqli_query($connection, "SELECT * FROM `pharmacy` WHERE `address` LIKE '%$area%' ") or die("Error");
                    $count = mysqli_num_rows($query2);
                    $outOfStockCount = 0;
                    while ($row = mysqli_fetch_array($query2)) {
                        $id = $row['pharmacyID'];
                        array_push($pharmacyIDs, $id);

                        $pharmacyID_pharmacy["$id"] = $row['name'];
                    }

                    $query3 = mysqli_query($connection, "SELECT * FROM `pharmacy_medicine` WHERE `pharmacyID` IN (" . implode(',', $pharmacyIDs) . ") AND `medID` LIKE $medID ") or die("Failed");

                    $count = mysqli_num_rows($query3);

                    if ($count == 0) {
                        echo '<div class="search-results">No available pharmacies with' . ' ' . $searchq . '</div>';
                    } else {
        ?>

                        <table class="tablePharm">
                            <?php

                            while ($row = mysqli_fetch_array($query3)) {
                                $amount = $row['amount'];
                                $name = $pharmacyID_pharmacy[$row['pharmacyID']];
                                $image = $row['medURL'];
                                $pharmacyID = $row['pharmacyID'];
                            ?>
                                <tr class="rowPharm">
                                    <td class="td1"><img class="imgPharm" src="uploads/<?= $image ?>"></td>
                                    <td class="td2"><?php echo '<h class="drug-name">' . $searchq . '</h>' ?><br><br>
                                        <?php echo '<h class="pharmacy-location">' . $name . " -" . $area . '</h>'; ?><br><br>

                                        <?php if ($amount == 0) {
                                            $outOfStockCount++;
                                            echo '<h class="availability out-of-stock">Out of stock</h>';
                                        } else {
                                            echo '<h class="availability available ">Available</h>';
                                        }
                                        ?></td>
                                    <td class="td3"><a href="viewMed.php?customerID=<?php echo $customerID ."&medID=".$medID."&pharmacyID=". $pharmacyID; ?>"><button id="view" name="view">View</button></a></td>
                                <?php
                            }
                            echo '</table>';
                            if ($outOfStockCount == $count) {
                                ?>
                                    <div class="notification-msg">
                                        <p>All pharmacies in the area are out of <?php echo $searchq; ?><br>
                                            Want to get notified when the item is available?
                                        </p>


                                        <button id="myBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Notify
                                        </button>

                                        <?php
                                        $query = mysqli_query($connection, "SELECT * FROM `notifyAvailability` WHERE `customerID` LIKE '$customerID' AND `medID` LIKE '$medID' AND `Area` LIKE '$area'");
                                        // $count=mysqli_num_rows($query);
                                        $row = mysqli_fetch_array($query);
                                        if ($count > 0) {
                                            if ($row['status'] == 'pending') {
                                        ?>
                                                <script>
                                                    document.getElementById("myBtn").disabled = true;
                                                </script>
                                                <div class="already-notified">
                                                    <p>Already notified</p>
                                                </div>
                                        <?php
                                            }
                                        }

                                        ?>

                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body are-you-sure">
                                                        Are you sure?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                        <a href="notify.php?search=<?php echo $searchq . "&find=" . $_GET['find'] . "&area=" . $area ?>"><button type="button" class="btn btn-primary" onclick="yes()" data-bs-dismiss="modal">Yes</button></a>

                                                        <script>
                                                            function yes() {

                                                                document.getElementById("myBtn").disabled = true;
                                                            }
                                                        </script>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <script>
                                        var myModal = document.getElementById('myModal')
                                        var myInput = document.getElementById('myInput')

                                        myModal.addEventListener('shown.bs.modal', function() {
                                            myInput.focus()
                                        })
                                    </script>
                <?php
                            }
                        }
                    } else {
                        echo '<div class="search-results">
                        Select an area.</div>';
                    }
                } else {
                }
            }
                ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>