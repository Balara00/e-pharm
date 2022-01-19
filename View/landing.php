<!DOCTYPE html>
<?php 
session_start();

include "../Controller/landing_contr.php";
include "../Model/navBar.model.php"; 
include "../Controller/navBar.contr.php";
$navbarContr = new NavBarContr();
?>
<html lang="en">

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/stylesLanding.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing <?= $_SESSION['customerID'] ;?></title>
</head>

<body>
    <img class="back" src="../assets/images/background.svg">
    <div class="sub">

        <div class="navlanding">
            <a href="landing.php?customerID=<?= $_SESSION['customerID'] ;?>"><img class="imgs bask" src="../assets/icons/search.svg"></a>
            <a href="../notification.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/notification.svg"></a>
            <?php 
            $notificationNo = $navbarContr->getCustomerNotificationNo($_SESSION['customerID']);
            if ($notificationNo != 0) {

                echo '<p class="notificationNo">'.$notificationNo.'</p>';
            
            }
            ?>
            <a href="../cart.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/cart.svg"></a>

            <a href="../account.php?customerID=<?=$_SESSION['customerID']?>"><img class="imgs bask" src="../assets/icons/user.svg"></a>
            <a href=""><button name="addPrescription" id="addPres" class="butn pres" type="submit">Add Prescription</button></a>


            <a href="../logout.php?customerID=<?=$_SESSION['customerID']?>"><button name="logOut" id="logout" class="butn log" type="submit">Logout</button></a>
            


        </div>
        <header>E-Pharm</header>

        <img class="two" src="../assets/images/2.png">
        <img class="one" src="../assets/images/1.png">

        <form id="Form" name="searchForm" action="results.php" method="get">
            <div class="wrap">
                <div class="search">

                    <input id="searchTerm" name="search" type="text" class="searchTerm" placeholder="What are you looking for?">
                    <button name="find" type="submit" class="searchButton">Find</button>


                </div>
            </div>
            <?php 
                $landingContr=new LandingContr();
                $areaList=$landingContr->getAreaList();
                $_SESSION['areaList'] = $areaList;
            ?>
            <select name="area" class="area">
            <option value="Area">Area</option>
                <?php 
                for($i =0; $i<count($areaList); $i++){
                    echo '<option value='."$areaList[$i]".'>'."$areaList[$i]".'</option> ';
                }
                ?>
                
            </select>
        </form>
        <script>
            const form = document.getElementById('Form');
            form.addEventListener('submit', (e) => {
                if (document.getElementById("searchTerm").value.length == 0) {
                    e.preventDefault();
                }

            });
        </script>

    </div>
    </nav>





</body>

</html>