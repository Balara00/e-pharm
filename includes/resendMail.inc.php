<?php
session_start();


$username = $_SESSION['username'];
$name = $_SESSION['name'];

include "../classes/dbconnection.classes.php";
include "../Model/resendMailModel.php";
include "../Controller/controller.php";
include "../Controller/resendMailContr.php";
include "../classes/MailSender.php";
$resendMailcontr = new ResendMailContr();
$resendMailcontr->resendMail($username, $name);
