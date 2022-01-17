<?php
session_start();


$username = $_SESSION['username'];
$name = $_SESSION['name'];

include "../classes/dbconnection.classes.php";
include "../model/resendMailModel.php";
include "../controller/controller.php";
include "../controller/resendMailContr.php";
include "../classes/MailSender.php";
$resendMailcontr = new ResendMailContr();
$resendMailcontr->resendMail($username, $name);
