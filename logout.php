<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["customerID"]);
    unset($_SESSION["pharmacyID"]);
    session_destroy();
    header("location:index.php");
?>
