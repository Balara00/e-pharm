<?php
session_start();
include "../classes/dbconnection.classes.php";
include "../model/notificPharmModel.php";
//include "../classes/Pharmacy_.classes.php";
include "../controller/controller.php";
include "../controller/notificPharmContr.php";
include "../view/notificPharmView.php";
$notificID = $_POST['notificID'];
$notificView = new NotificPharmView();
$notificView->setRead($notificID);
