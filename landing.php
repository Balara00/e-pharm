
<!DOCTYPE html>
<?php include('connection.php');

?>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylesLanding.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <img class="back" src="background.svg">
    <div class="sub">

        <div class="navlanding">

            <a href="cart.php"><img class="imgs bask" src="basket.svg"></a>

            <button name="addPrescription" id="addPres" class="butn pres" type="submit">Add Prescription</button>

            <script type="text/javascript">
                document.getElementById("addPres").onclick = function() {
                    location.href = "www.addPrescription.php";
                };
            </script>

            <a href="logout.php"><img class="imgs logo" src="logo.svg"></a>

            <button name="logOut" id="logout" class="butn log" type="submit">Logout</button>
            <script type="text/javascript">
                document.getElementById("logout").onclick = function() {
                    location.href = "www.yoursite.com";
                };
            </script>


        </div>
        <header>E-Pharm</header>

        <img class="two" src="2.png">
        <img class="one" src="1.png">

        <form id="Form" name="searchForm" action="results.php" method="get">
            <div class="wrap">
                <div class="search">

                    <input id="searchTerm" name="search" type="text" class="searchTerm" placeholder="What are you looking for?">
                    <button name="find" type="submit" class="searchButton">Find</button>


                </div>
            </div>
            <select name="area" class="area">
                <option value="Area">Area</option>
                <option value="colombo">Colombo</option>
                <option value="Kuliyapitiya">Kuliyapitiya</option>
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
>>>>>>> origin
