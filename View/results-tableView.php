
<table class="tablePharm">
            
<?php 
$outOfStockCount=0;
$result= $_SESSION['result'];
$pharmacyID_pharmacy = $this->getpharmacyID_pharmacy();

foreach($result as $row) {
    //pharmacy_medicine object
    $pharmacyMed = new PharmacyMedicine($row['pharmacyID'],$row['medID'],$row['amount'],$row['medURL']);
    
    $name = $pharmacyID_pharmacy[$row['pharmacyID']];
    
?>
    <tr class="rowPharm">
        <td class="td1"><img class="imgPharm" src="../uploads/<?= $pharmacyMed->getmedURL() ?>"></td>
        <td class="td2"><?php echo '<h class="drug-name">' . $this->getsearchq() . '</h>' ?><br><br>
            <?php echo '<h class="pharmacy-location">' . $name . " -" . $this->getarea() . '</h>'; ?><br><br>

            <?php if ($pharmacyMed->getamount() == 0) {
                $outOfStockCount++;
                echo '<h class="availability out-of-stock">Out of stock</h>';
            } else {
                echo '<h class="availability available ">Available</h>';
            }
            ?></td>
        <td class="td3"><a href="../medDetail.php?customerID=<?php echo $this->getcustomerID() ."&medID=".$pharmacyMed->getmedID()."&pharmacyID=". $pharmacyMed->getpharmacyID(); ?>"><button id="view" name="view">View</button></a></td>
    <?php
}
echo '</table>';
if ($outOfStockCount == $this->getcount()) {?>
    
    <div class="notification-msg">
        <p>All pharmacies in the area are out of <?php echo $this->getsearchq(); ?><br>
            Want to get notified when the item is available?
        </p>
        <button id="myBtn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Notify
        </button>

        <?php
        $notifyResult = $this-> searchNotify($this->getcustomerID(), $pharmacyMed->getmedID(), $this->getarea());
        
        if ($notifyResult != null) {
            if ($notifyResult['status'] == 'pending') {
        ?>
                <script>
                    document.getElementById("myBtn").disabled = true;
                </script>
                <div class="already-notified">
                    <p>Already notified</p>
                </div>
            <?php
                }
            }
            ?>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body are-you-sure">
                            Are you sure?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <form method="post" >
                            <button type="submit" name="yes" class="btn btn-primary" onclick="yes()" data-bs-dismiss="modal">Yes</button>
                            </form>
                            <?php
                            
                            if(isset($_POST['yes'])){
                                if($this->searchNotify($this->getcustomerID(), $pharmacyMed->getmedID(), $this->getarea())==null){
                                    $this->setNotify($this->getcustomerID(),$this->getmedID(),$this->getarea(),"pending");
                                }else{
                                    $this->updateNotify($this->getcustomerID(),$this->getmedID(),$this->getarea(),"pending");
                                }
                            } 
                            ?>
                            <script>
                                function yes() {

                                    document.getElementById("myBtn").disabled = true;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            var myModal = document.getElementById('myModal')
            var myInput = document.getElementById('myInput')

            myModal.addEventListener('shown.bs.modal', function() {
                myInput.focus()
            })
        </script>
<?php
            }