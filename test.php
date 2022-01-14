<!-- <?php
require_once "pdo.php";

  $stmt = $pdo -> prepare("SELECT `area` FROM pharmacy");
  $stmt -> execute(array());
  $pharmacyDet = $stmt -> fetchAll(PDO::FETCH_ASSOC);  

  if ($pharmacyDet === false) {
      $_SESSION['error'] = "Can't find data record in database table course.";
      header("Location: index.php");
  }

  $dis_array = array();

  foreach ($pharmacyDet as $x) {
    echo (implode("", $x));
    echo '<br>';
    array_push($dis_array, (implode("", $x)));
  }

  echo '<br>';

  $f = array_unique($dis_array);

  echo '<ul>';
  foreach ($f as $key) {
    echo '<li>'.$key.'</li>';
  }
  echo '</ul>';
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<input type="hidden" id="date" name="date" value="CurrentTime"> 
<input type="hidden" id="time" name="time" value="CurrentDate">  
    <script type="text/javascript">
        var d = new Date();

        // Set the value of the "date" field
        document.getElementById("date").value = d.toDateString();
      
        console.log(d.toDateString())

        // Set the value of the "time" field
        var hours = d.getHours();
        var mins = d.getMinutes();
        var seconds = d.getSeconds();
        document.getElementById("time").value = hours + ":" + mins + ":" + seconds;
        console.log(d.toDateString() + " " + hours + ":" + mins + ":" + seconds);
    </script>
</body>
</html>