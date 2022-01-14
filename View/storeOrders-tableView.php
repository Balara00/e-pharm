<?php 
    $result = $_SESSION['result'];
    $medObjs = $_SESSION['medObjs'];
    $customers = $_SESSION['customers'];
    $medIDs = $_SESSION['medIDs'];
    $amounts = $_SESSION['amounts'];
?>

<div class="table-pharm">
    <div class="container">
        <div class="row row-cols-1">
        <?php  $i= 0;
        foreach($result as $row){
            $customer = $customers[$i];
        ?>
            <div class="col backk">
                <div class="inside-row">
                            
                <?php echo '<h class="date">' . $row['date']  . '</h>' ?><br>
                <?php echo '<h class="price">Rs.' . $row['price']  . '</h>' ?><br>
                <?php echo '<h class="customer-name">' . $customer['name'].' - 0'.$customer['mobile'] . '</h>' ?><br>
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
                if($row['prescriptionURL']!=null){
                    ?>

                    <div id="pres-container<?= $i?>" class="pres-container hidden">
                    <button class="close-modal" onclick="close(<?= $i?>)">&times;</button>
                    <img src="../uploads/<?=$row['prescriptionURL']?>" id="presImg<?= $i?>" class="presImg ">
                    </div>
                    <?php
                }

                if($row['status'] == "cancelled"){
                    echo '<p class="status cancelled">Order cancelled</p>';
                }
                if($row['orderType']== "delivery" && $row['deliveryStatus'] == "delivered"){
                    echo '<p  class="status delivered">Delivery completed</p>';
                }

                if($row['orderType']== "pickup" && $row['approveStatus'] == "accepted"){
                    echo '<p  class="status delivered">Reserved</p>';
                
                }
                
                ?>
                
                <form action="../includes/acceptdeclineOrder.php?orderID=<?= $row['orderID']; ?>&type=<?= $row['orderType']?>" method="post">
                    <button id="myBtn<?php echo $i; ?>" name="accept" onclick='return confirm("Are you sure?")' class="btn-primary btn accept" type="submit">Accept order</button>
                </form>
                
                <form action="../includes/acceptdeclineOrder.php?orderID=<?= $row['orderID']; ?>&type=<?= $row['orderType']?>" method="post">
                    <button id="myreceived<?php echo $i; ?>" name="decline" onclick='return confirm("Are you sure?")' type="submit" class="btn-primary btn decline" >Decline Order</button>
                </form>
                
                <button class="viewPres" id="viewPres<?= $i?>" onclick="displayPres(<?= $i?>)" >View Prescription</button>

                <script>
                            function displayPres(i){
                                document.getElementById("pres-container"+i).classList.remove('hidden');
                                
                            }
                            function close(i){
                                document.getElementById("pres-container"+i).classList.add('hidden');
                            }
                            
                    </script>
                <?php

                if($row['orderType'] == "delivery"){ ?>
                    <form action="../includes/acceptdeclineOrder.php?orderID=<?= $row['orderID']; ?>&type=<?= $row['orderType']?>" method="post">
                    <button id="deliverBtn<?php echo $i; ?>" name="deliver" onclick='return confirm("Are you sure?")' class="deliverBtn" type="submit">Delivered</button>
                </form>

               <?php 
                }

                if(($this->getOrder($row['orderID']))['approveStatus'] == 'accepted' || ($this->getOrder($row['orderID']))['approveStatus'] == 'declined') {
                        
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
                if( ($this->getOrder($row['orderID']))['deliveryStatus'] == 'delivered'){
                    ?>
                    <script>
                        function disabledeliverBtns(i){
                            document.getElementById("deliverBtn"+i).disabled = true;
                             document.getElementById("deliverBtn"+i).setAttribute("style","display:none;");

                        }
                            
                        
                    </script>
                    <?php 
                    echo '<script> disabledeliverBtns('.$i.'); </script>';
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


    
        




    

