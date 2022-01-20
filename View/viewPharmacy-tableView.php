
<?php 
    $result = $_SESSION['result'];
    $search = $this->getsearchq();
    $pharmacyMed = new PharmacyMedicine($result['pharmacyID'],$result['medID'],$result['amount'],$result['medURL']);
?>
<div class="table-pharm">
    <div class="container">
        <div class="row row-cols-3">
            <div class="col backk">
                <div class="inside-row">
                <a href="../medDetail.php?customerID=<?php echo $this->getcustomerID() ."&medID=".$pharmacyMed->getmedID()."&pharmacyID=". $pharmacyMed->getpharmacyID(); ?>"> <img class="imgPharm" src="../uploads/<?= $pharmacyMed->getmedURL() ?>"></a><br>
                <?php echo '<h class="drug-name">' . $this->getsearchq() . '</h>' ?><br>
                <?php echo '<h class="price">Rs.' .$result['price'] . '</h>' ?><br>
                <?php if ($pharmacyMed->getamount() == 0) {
                    echo '<h class="availability out-of-stock">Out of stock</h>';
                } else {
                    echo '<h class="availability available ">Available</h>';
                }
                ?>
                </div>
            </div>
            
        </div>
    </div>
</div>