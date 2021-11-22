<?php
session_start();
include_once "pdo.php";

if(isset($_POST["_continue"]) && isset($_POST["email"])){
  //echo htmlentities($_POST["code"]);
  $stmt = $pdo->prepare("SELECT verificationCode From customer WHERE username = :xyz");
  $stmt->execute(array(':xyz' => $_POST["email"]));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ( $row['validationCode'] !== $_POST['code'] ){
    $_SESSION['error'] = 'Incorrect Validation Code.';
    header( 'Location: verifyCode.php?email='.$_GET["email"] ) ;
    return;
  }
  else{
    header("Location: resetPassword.php?email=".$_GET["email"]);
  }
}

$stmt = $pdo->prepare("SELECT * FROM customer where username = :xyz");
$stmt->execute(array(":xyz" => $_GET['email']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
  $_SESSION['error'] = 'e-mail address is missing';
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
     <link rel="stylesheet" type="text/css" href="verifyCode.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
     <title></title>
   </head>
   <body>
     <div class="MiddleBg">
       <h1 id="epharm">E-Pharm</h1>
       <div class="CodeForm">
         <div class="Code">
           <h3 id="note">Check Your Emails</h3>
         </div>
         <div class="intro">
           <p>We sent your verification code to the <b> <?= htmlentities($row['username']) ?> </b> email address.
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
               <img src="verification.svg" alt="">
               <input type="text" name="code" placeholder="verification code" /required>
             </div>
             <div class="WhiteSpace">

             </div>
             <div class="ResetBtn">
               <button type="submit" class="btn" name="_continue">Continue</button>
             </div>
           </form>
           <div class="CodeBottom">
             Didn't recieve code yet?
             <a href="forgetPassword.php?email=".$row['username'] id="forgetPasswordLink">Resend Code</a>
           </div>
           <div class="CodeBottom">
             Back to
             <a href="login.php" id="loginLink">Login</a>
           </div>
         </div>
       </div>
     </div>
   </body>
 </html>
