<?php

include_once "pdo.php";
session_start();
if(!isset($_SESSION["username"]))
{
 header("location:login.php");
}
//if (isset($_POST['button'])) {
  //header("Location:login.php");
//}

$stmt = $pdo->prepare("SELECT * FROM customer where customerID = :xyz");
$stmt->execute(array(":xyz" => $_GET['customerID']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
  $_SESSION['error'] = 'customer id is missing';
  header( 'Location: login.php' ) ;
  return;
}

?>

<html><head></head>
<body>
<?php
if ( isset($_SESSION['error']) ) {
echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
unset($_SESSION['success']);
}
echo('<table border="1">'."\n");
echo "<tr><td>";
echo(htmlentities($row['name']));
echo("</td><td>");
echo(htmlentities($row['username']));
echo("</td><td>");
echo(htmlentities($row['password']));
//echo("</td><td>");
//echo('<a href="edit.php?user_id='.$row['user_id'].'">Edit</a> / ');
//echo('<a href="delete.php?user_id='. $row['user_id'].'">Delete</a>');
//echo("\n</form>\n");
echo("</td></tr>\n");
?>
</table>
<div class="container box">
   <h3 align="center">Welcome - <?php echo $_SESSION["username"]; ?></h3>
   <br />
   <p><a href="logout.php">Logout</a></p>
</div>
<!--<button type="submit" name="button">Log Out</button>-->
