
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
                <img class="imgPharm" src="../uploads/<?= $pharmacyMed->getmedURL() ?>"><br>
                <?php echo '<h class="drug-name">' . $this->getsearchq() . '</h>' ?><br>
                <?php echo '<h class="price">Rs.' . $result['price'] . '</h>' ?><br>
                <a href="edit.php"><button class="edit" type="submit">Edit</button></a>
                </div>
            </div>
            
        </div>
    </div>
</div>