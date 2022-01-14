<?php
include_once ("pdo.php");

if(isset($_POST['submit'])){
    $file=$_FILES['file'];

    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize=$_FILES['file']['size'];
    $fileError=$_FILES['file']['error'];
    $fileType=$_FILES['file']['type'];

    $fileExt=explode('.',$fileName);
    $fileActualExt=strtolower(end($fileExt));

    $allowed=array('jpg','jpeg','png');

    if(in_array($fileActualExt,$allowed)){
        if($fileError===0){
            if($fileSize<1000000){
                $fileNameNew=uniqid('',true).".".$fileActualExt;
                $fileDestination='uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName,$fileDestination);

                $sql = "INSERT INTO `prescription`(`customerID`,`prescURL`,`area`,`note`) VALUES (:cID, :purl, :area, :note)";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute(array(
                    ':cID' => '1',
                    ':purl' => $fileNameNew,
                    ':area' => 'Matara',
                    ':note' => 'Test1'

                ));
                // $query=mysqli_query($pdo, "INSERT INTO `pharmacy_medicine`(`pharmacyID`,`medID`,`amount`,`medURL`) VALUES ('1005','100','5','$fileNameNew')") or die("failed");
                echo $fileNameNew;
                // header("Location: insertimage.php");
            }else{
                echo "file too big";
            }
        }else{
            echo "error in uploading file";
        }
    }else{
        echo "wrong type";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="upload_B.php" method="post" enctype="multipart/form-data">

        <input type="file" name="file">
        <!-- <input type="text" name="txt" id=""> -->
        <button type="submit" name="submit">upload</button>

</body>
</html>
