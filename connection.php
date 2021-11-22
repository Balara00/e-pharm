<?php 

$connection = mysqli_connect('localhost','root','','e_pharm');

if(mysqli_connect_errno()){
    die('Database connection failed '.mysqli_connect_error());
}


?>