<?php 
include ("connection.php");

$searchq='Paracetamol';
$area='Kuliyapitiya';
$searchq=strtolower($searchq);
$searchq=preg_replace("#[^0-9a-z]#i","",$searchq);
$medID;
$medPrice;
$pharmacyIDs=array();

$pharmacyID_pharmacy;
$query1=mysqli_query($connection,"SELECT * FROM medicine WHERE name LIKE '%$searchq%'") or die ("could not search");

$count=mysqli_num_rows($query1);
if($count==0){
    $output='No search results';
}else{
    $row= mysqli_fetch_array($query1);
    $medID=$row['medID'];
    $medPrice=$row['price'];
    

}

$query2=mysqli_query($connection, "SELECT * FROM `pharmacy` WHERE `address` LIKE '%$area%' ") or die("No pharmacy available in given location") ;
$count=mysqli_num_rows($query2);

while($row= mysqli_fetch_array($query2)){
    $id=$row['pharmacyID'];
    array_push($pharmacyIDs,$id);
    
    $pharmacyID_pharmacy["$id"]=$row['name'];

}


$query3=mysqli_query($connection,"SELECT * FROM `pharmacy_medicine` WHERE `pharmacyID` IN (".implode(',',$pharmacyIDs).") AND `medID` LIKE $medID ") or die("Failed");
 
$count=mysqli_num_rows($query3);

if($count==0){
    echo "No available pharmacies with"." ".$searchq;
}else{
    while($row= mysqli_fetch_array($query3)){
        $amount=$row['amount'];
        $name=$pharmacyID_pharmacy[$row['pharmacyID']];
        echo $searchq."\n".
            $name." - ".$area."\n";
        if($amount==0){
            echo "Out of stock";
        }else{
            echo "Available Quantity - ".$amount;
        }
        
    }
}



?>