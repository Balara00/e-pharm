<?php
session_start();
include "../classes/dbconnection.classes.php";
include "../Model/notificPharmModel.php";
//include "../classes/Pharmacy_.classes.php";
include "../Controller/controller.php";
include "../Controller/notificPharmContr.php";
include "../View/notificPharmView.php";
$notificID = $_POST['notificID'];
$notificView = new NotificPharmView();
$notificView->setRead($notificID);
