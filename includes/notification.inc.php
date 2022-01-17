<?php
session_start();
include "../classes/dbconnection.classes.php";
include "../model/notificModel.php";
include "../classes/Pharmacy_.classes.php";
include "../controller/controller.php";
include "../controller/notificContr.php";
include "../view/notificView.php";
$notificID = $_POST['notificID'];
$notificView = new NotificView();
$notificView->setRead($notificID);
