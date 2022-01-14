<?php 
    $result = $_SESSION['result'];
    $medObjs = $_SESSION['medObjs'];
    $pharmacyObjs = $_SESSION['pharmacyObjs'];
    $medIDs = $_SESSION['medIDs'];
    $amounts = $_SESSION['amounts'];
?>

<div class="table-pharm">
    <div class="container">
        <div class="row row-cols-1">
        <?php  $i= 0;
        $btnId=0;
        foreach($result as $row){
            $pharmacy = $pharmacyObjs[$i];
            
        ?>
            <div class="col backk">
                <div class="inside-row">
                            
                <?php echo '<h class="date">' . $row['date']  . '</h>' ?><br>
                <?php echo '<h class="price">Rs.' . $row['price']  . '</h>' ?><br>
                <?php echo '<h class="pharmacy-name">' . $pharmacy->getname().' - '.$pharmacy->getarea() . '</h>' ?><br>
                <h5 class="orderSummary">Order Summary</h5>

                <?php 
                $notes = "";
                $medArray = $medObjs[$i];
                $amountArr = $amounts[$i];
                $j=0;
                foreach($medArray as $arr){
                    $medID2= $medIDs[$i][$j];
                    $med = $medArray[$j]->getAll($medID2);
                    $amount = $amountArr[$j];
                    $notes = $notes.($med['name']).' - '.$amount."\n" ;
                    $notes= str_replace("\n",'<br />',$notes);
                    
                    $j++;
                }
                
                echo '<div class="orderDetails">'.$notes.'</div>';

                if($row['approveStatus'] == "accepted"){
                    echo '<p class="approveStatus accepted">Pharmacy Accepted</p>';
                }
                if($row['approveStatus'] == "declined"){
                    echo '<p  class="approveStatus declined">Pharmacy Declined</p>';
                }
                    
                ?>
                    
                <form action="../includes/cancelOrder.php?orderID=<?= $row['orderID']; ?>" method="post">
                    <button id="myBtn<?php echo $i; ?>" name="cancel" onclick='return confirm("Are you sure?")' class="btn-primary btn cancelOrder" type="submit">Cancel order</button>
                </form>
                
                <form action="../includes/receiveOrder.php?orderID=<?= $row['orderID']; ?>&customerID=<?= $this->getCustomerID(); ?>&pharmacyID=<?= $pharmacy->getpharmacyID();?>" method="post">
                    <button id="myreceived<?php echo $i; ?>" name="received" type="submit" class="btn-primary btn received" >Received</button>
                </form>
                
                <?php
                if(($this->getOrder($row['orderID']))['status'] == 'received' || ($this->getOrder($row['orderID']))['status'] == 'cancelled') {
                        
                        ?>
                        <script>
                            function disableBtns(i){
                                document.getElementById("myBtn"+i).disabled = true;
                                // document.getElementById("myBtn"+i).setAttribute("style","display:none;")

                                document.getElementById("myreceived"+i).disabled = true;
                                // document.getElementById("myreceived"+i).setAttribute("style","display:none;")
                            }
                                
                            
                        </script>
                        <?php 
                        echo '<script> disableBtns('.$i.'); </script>';
                    }
                ?>    
                
                </div>
            </div>
            <?php $i++; 
            }
            
            ?>  
            
              
        </div>
    </div>
</div>


    
        




    

