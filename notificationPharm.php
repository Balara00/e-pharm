<?php
include "classes/dbconnection.classes.php";
include "Model/notificPharmModel.php";
include "classes/Pharmacy.classes.php";
include "Controller/controller.php";
include "Controller/notificPharmContr.php";
include "View/notificPharmView.php";
session_start();
$_SESSION['pharmacyID'] = 1;
$notificPharmView = new notificPharmView();
$ntfs = $notificPharmView->getNotifications($_SESSION['pharmacyID']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link rel="stylesheet" href="assets/css/notification.css">
    <title>Notifications</title>
</head>

<body class="index_body">
    <div class="container">
        <?php include "navBar.php" ?>
        <div class="out-dv">
            <div class="in-dv">
                <div class="accordion" id="accordionExample">
                    <?php
                    $x = 0;
                    foreach ($ntfs as $notification) {
                        $x += 1;
                    ?>
                        <div class="accordion-item" style="background-color:#f1f1f1">
                            <h2 class="accordion-header" id="headingOne_<?php echo $x ?>">
                                <?php
                                if ($notification['notificationState'] == '0') {
                                ?>
                                    <button class="accordion-button collapsed" id="item_<?php echo $x ?>" style="background-color:#DEE9FF;color:#0038FF" type="button" name='read_' data-bs-toggle="collapse" data-bs-target="#collapseOne_<?php echo $x ?>" aria-expanded="true" aria-controls="collapseOne_<?php echo $x ?>" onclick="markAsRead('item_<?php echo $x ?>',<?php echo $notification['notificationID'] ?>)">
                                        At <?php echo $notification['dateTime'] ?>
                                    </button>
                                <?php
                                } else {
                                ?>
                                    <button class="accordion-button collapsed" id="item_<?php echo $x ?>" style="background-color:#c1c1c1;color:#000" type="button" name='read_' data-bs-toggle="collapse" data-bs-target="#collapseOne_<?php echo $x ?>" aria-expanded="true" aria-controls="collapseOne_<?php echo $x ?>" onclick="markAsRead('item_<?php echo $x ?>',<?php echo $notification['notificationID'] ?>)">
                                        At <?php echo $notification['dateTime'] ?>
                                    </button>
                                <?php
                                }
                                ?>
                            </h2>
                            <div id="collapseOne_<?php echo $x ?>" class="accordion-collapse collapse" aria-labelledby="headingOne_<?php echo $x ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="color:#666">
                                    <?php echo $notification['notification'] ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function markAsRead(x, notificID) {
            document.getElementById(x).style.backgroundColor = "rgb(193,193,193 )";
            document.getElementById(x).style.color = "rgb(0,0,0 )";
            $.ajax({
                type: 'post',
                url: 'includes/notificationPharm.inc.php',
                data: {
                    notificID: notificID
                },
            });

        }
    </script>
</body>

</html>