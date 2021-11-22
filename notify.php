<?php
include('connection.php');
    session_start();
    // $customer=$_SESSION['customerID'];                                        
    $query=mysqli_query($connection, "INSERT INTO  `notifyAvailability`(`customerID`,`medID`,`area`,`status`) VALUES ('1','101','Colombo','pending')") or die("Error") ;
    
    header("Location:results.php?"."search=".$_GET['search']."&find=".$_GET['find']."&area=".$_GET['area']);


 ?>