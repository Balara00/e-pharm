
<?php 
    $result = $_SESSION['result'];
    $medObjs = $_SESSION['medObjs'];
    
?>
<div class="table-pharm">
    <div class="container">
        <div class="row row-cols-3">
        <?php  $i= 0;
        foreach($result as $row){
            $pharmacyMed = new PharmacyMedicine($row['pharmacyID'],$row['medID'],$row['amount'],$row['medURL']);
            $medicine = $medObjs[$i]->getAll($row['medID']);

            $i++;
        
        ?>
            <div class="col backk">
                <div class="inside-row">
                <img class="imgPharm" src="../uploads/<?= $pharmacyMed->getmedURL() ?>"><br>
                <?php echo '<h class="drug-name">' . $medicine['name'] . '</h>' ?><br>
                <?php echo '<h class="price">Rs.' . $row['price']  . '</h>' ?><br>
                <?php if ($pharmacyMed->getamount() == 0) {
                    echo '<h class="availability out-of-stock">Out of stock</h>';
                } else {
                    echo '<h class="availability available ">Available</h>';
                }
                ?>
                </div>
            </div>
            <?php } ?>  
              
        </div>
    </div>
</div>