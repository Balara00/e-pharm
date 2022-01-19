<?php
session_start();
include "../classes/dbconnection.classes.php";
include "../Model/notificModel.php";
include "../classes/Pharmacy_.classes.php";
include "../Controller/controller.php";
include "../Controller/notificContr.php";
include "../View/notificView.php";
$notificID = $_POST['notificID'];
$notificView = new NotificView();
$notificView->setRead($notificID);
