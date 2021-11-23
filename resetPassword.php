<?php
session_start();
include_once "pdo.php";

if(isset($_POST["firstPw"]) && isset($_POST["secondPw"])){
  //echo htmlentities($_POST["code"]);
  if ( $_POST['firstPw'] !== $_POST['secondPw'] ){
    $_SESSION['error'] = 'Two passwords do not match!';
    header( 'Location: resetPassword.php?email='.$_GET["email"] ) ;
    return;
  }
  else{
    $encryptedPw = md5($_POST['firstPw']);
    $stmt = $pdo->prepare("SELECT password From customer WHERE username = :xyz");
    $stmt->execute(array(':xyz' => $_POST["email"]));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
      $sql = "UPDATE customer SET password = :password WHERE username = :email";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':password' => $encryptedPw,
        ':email' => $_POST['email']));
      $_SESSION['success'] = 'Password reset successfully!';
      header("Location: login.php");
    }
    else{
      $_SESSION['error'] = 'No any account with that email address!';
      header( 'Location: resetPassword.php?email='.$_GET["email"] ) ;
      return;
    }

  }
}

$stmt = $pdo->prepare("SELECT * FROM customer where username = :xyz");
$stmt->execute(array(":xyz" => $_GET['email']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
  $_SESSION['error'] = 'e mail address is missing';
  header( 'Location: forgetPassword.php' ) ;
  return;
}
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" type="text/css" href="assets/css/resetPassword.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
     <title></title>
   </head>
   <body>
     <div class="MiddleBg">
       <h1 id="epharm">E-Pharm</h1>
       <div class="ResetForm">
         <div class="Reset">
           <h3 id="note">Reset Password</h3>
         </div>
         <div class="intro">
           <p>
           You can reset your password for your E-Pharm account with
           the email address of <?= htmlentities($row['username']) ?>
         </p>
         </div>
         <div class="WhiteSpace">

         </div>
         <div class="error">
           <?php
             if(isset($_SESSION['error']) ) {
               echo('<p style="color:red;
               text-align: center;
               font-family: Ubuntu;
               position: relative;
               ">'.htmlentities($_SESSION['error'])."</p>\n");
               unset($_SESSION['error']);
             }
             ?>
         </div>
         <div class="Form">
           <form method="post">
             <input type="hidden" name="email" value="<?= $row['username'] ?>">
             <div class="TextInput">
               <input type="password" name="firstPw" placeholder="Enter new password" /required>
             </div>
             <div class="WhiteSpace">

             </div>
             <div class="TextInput">
               <input type="password" name="secondPw" placeholder="Confirm password" /required>
             </div>
             <div class="WhiteSpace">

             </div>
             <div class="ResetBtn">
               <button type="submit" class="btn" name="reset">Reset Password</button>
             </div>
           </form>
           <div class="CodeBottom">
             Back to
             <a href="login.php" id="loginLink">Login</a>
           </div>
         </div>
       </div>
     </div>
   </body>
 </html>
