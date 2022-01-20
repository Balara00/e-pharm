<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/orderNow.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    
    <title>Order Now</title>
</head>
<body class="orderNow_body">
    <?php
        include "classes/dbconnection.classes.php";
        include "classes/pharmacy_medicine.class.php";
        include "classes/pharmacy.class.php";
        include "classes/medicine.class.php";
        include "Model/orderNow.model.php"; 
        include "Controller/orderNow.contr.php";
        include "View/orderNow.view.php"; 

        // $_SESSION['buyNow'] = "true";
        // $_SESSION['reseveNow'] = "true";
        // $_SESSION['order'] = "buyNow";
        // $_SESSION['customerID'] = '1';
        // $_SESSION['pharmacyID'] = '1';
        // $_SESSION['medQuantityArr'] = array('1' => '2', '2' => '4', '1' => '3');
        
        $order_view = new OrderNowView();

        $medArr = $order_view->getMedArr();
    ?>

<div class="orderNow_container">
    <?php include "navBar.php" ?>
    <div class="orderDiv">
     <div class="medInfo">
    <form action="includes/orderNow.inc.php" method="post" enctype="multipart/form-data" class="orderForm">

    <table class="table table-hover orderTable">
        <thead class="orderTableHead">
            <tr>
            <th scope="col">Product</th>
            <th scope="col">Unit Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Price</th>
            </tr>
        </thead>

        <tbody class="orderTableBody">

        <?php
        $total = 0;
            foreach ($medArr as $obj) {
                echo '<tr>';
                echo '<td>' .$order_view->getMedName($obj). '</td>';
                echo '<td>Rs. ' .$order_view->getMedPrice($obj). '</td>';
                echo '<td>' .$order_view->getMedQty($obj). '</td>';

                $price = $order_view->getPrice($obj);
                $total += $price;

                echo '<td>Rs. ' .$price. '</td>';
                echo '</tr>';
            }
        ?>

        </tbody>
        <tfoot class="table-primary orderTableFooter" >
            <tr class="totalRow">
                <td class="myTotal">My Total</td>
                <td></td>
                <td></td>
                <!-- <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> -->
                <td>Rs. <?php echo $total ?></td>
                <!-- <td></td> <td></td> <td></td> -->
                
            </tr>
        
        </tfoot>
    
    </table>
        </div>

    <div class="cusInfo">
        <p class="dateTxt">Date</p>
        
        <?php
        date_default_timezone_set('Asia/Colombo');
        $date =  date('m/d/Y', time());
        ?>
        <p class="dateInp form-control"><?php echo $date ?></p>
        <!-- <input type="text" name="date" class="dateInp form-control" aria-label="readonly input" readonly value=<?php echo $date ?>> -->

        <p class="nameTxt">Name</p>
        <p class="nameInp form-control" ><?php echo $order_view->getCustomerName(); ?></p>

        <!-- <input type="text" name="cus_name" class="nameInp form-control" aria-label="readonly input" readonly value=<?php echo $order_view->getCustomerName(); ?>> -->
        <?php
       if(isset($_SESSION['order']) && $_SESSION['order'] == "reserveNow"){
        ?>
        <p class="phoneTxt">
            Phone Number</p>
        <input type="number" name="phone" id="" class="phoneInp form-control" value=<?php echo $order_view->getCustomerNo(); ?> required oninput="validity.valid||(value='');" onKeyPress="if(this.value.length==10) return false;">

        <?php
       }?>
        
       <?php
        if(isset($_SESSION['order']) && $_SESSION['order'] == "buyNow"){
        ?>
        <p class="phoneTxt">
            Phone Number</p>
        <input type="number" name="phone" id="" class="phoneInp form-control" required value=<?php echo $order_view->getCustomerNo(); ?> required oninput="validity.valid||(value='');" onKeyPress="if(this.value.length==10) return false;">

        <p class="addressTxt">Address</p>
        <input type="text" name="address" id="" class="adderssInp form-control" required value=<?php echo $order_view->getCustomerAddress(); ?>>     

        <?php
       }?>

        <label for="upload" class="form-label uploadPresc_txt">Prescription</label>
        <input type="file" class="form-form-control-file uploadPresc_photo" name="prescPhoto" id="mypres" aria-describedby="acceptedFilesBlock" accept=".png, .jpg, .jpeg"/>
        <input type="hidden" name="tot" value=<?php echo $total ?>>
        <input type="submit" value="Confirm" class="btn btn-primary confirmOrderBtn" name="confirmOrder" data-bs-toggle="modal" data-bs-target="#myModal"/>
    
    </div>

   </form>
    </div>

<?php if (isset($_SESSION['success'])) { ?>
<!-- The Modal -->
<div id="myModal" class="modal" >
<!-- Modal content -->
<div class="modal-content">

<div >
    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    
    <img class="imgPrescription mx-auto" src="assets/images/prescription.svg">
    <p class="mx-auto success">Placed Order Successfully.</p>

    </div>
</div>

<script>
        // Get the modal
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }   

    var btn = document.getElementById("confirmBtn");

    btn.onclick = function() {
        btn.style.display = "none";
    }
    

</script>

<?php
// if (isset($_SESSION['success'])) {
unset($_SESSION['success']);
}
?>
</div>
</body>
</html>
