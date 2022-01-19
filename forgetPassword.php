<?php
session_start();
// include_once "pdo.php";
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\SMTP;
//
// // require 'C:/laragon/bin/php/phpMailer/vendor/autoload.php';
// require 'vendor/autoload.php';
//
// if (isset($_POST["send_code"])) {
//
//   $email = $_POST["email"];
//
//   $customerStmt = $pdo->prepare("SELECT * FROM customer where username = :xyz");
//   $customerStmt->execute(array(":xyz" => $_POST["email"]));
//   $customerRow = $customerStmt->fetch(PDO::FETCH_ASSOC);
//   if ( $customerRow === false ) {
//     $_SESSION['error'] = 'Incorrect Email Address';
//     header( 'Location: forgetPassword.php' ) ;
//     return;
//   }
//
//   $mail = new PHPMailer(true);
//
//   try{
//     $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
//
//     //Send using SMTP
//     $mail->isSMTP();
//
//     //Set the SMTP server to send through
//     $mail->Host = 'smtp.gmail.com';
//
//     //Enable SMTP authentication
//     $mail->SMTPAuth = true;
//
//     //SMTP username
//     $mail->Username = 'ktst428@gmail.com';
//
//     //SMTP password
//     $mail->Password = '*AbbbbbA*';
//
//     //Enable TLS encryption;
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//
//     //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
//     $mail->Port = 587;
//
//     //Recipients
//     $mail->setFrom('ktst428@gmail.com', 'E-Pharm');
//
//     //Add a recipient
//     $mail->addAddress($email);
//
//     //Set email format to HTML
//     $mail->isHTML(true);
//
//     $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
//
//     $mail->Subject = 'Email verification';
//     $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
//
//     $mail->send();
//     // echo 'Message has been sent';
//     $customerSql = "UPDATE customer SET verificationCode = $verification_code WHERE username = :email";
//     $customerStmt = $pdo->prepare($customerSql);
//     $customerStmt->execute(array(':email' => $_POST['email']));
//
//     header("Location: verifyCode.php?email=".$email);
//
//   }
//  catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//   }
// }
//


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/forgetPassword.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>ForgetPassword</title>
  </head>
  <body>
    <div class="MiddleBg">
      <h1 id="epharm">E-Pharm</h1>
      <div class="EmailForm">
        <div class="ForgetPw">
          <h3 id="note">Forget Password?</h3>
        </div>
        <div class="intro">
          <p>No Problem! <br> Enter your email below
            We will send you an email with a verification code
            to reset your password.</p>
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
              unset($_SESSION['error']);
            }
            ?>
        </div>
        <div class="Form">
          <form action="includes/forgetPW.inc.php" method="post">
            <div class="TextInput">
              <img src="assets/icons/mailIcon.svg" height="14px">
              <input type="text" name="email" placeholder="email address">
            </div>
            <div class="WhiteSpace">

            </div>
            <div class="SendBtn">
              <button type="submit" class="btn" name="send_code">Send Code</button>
            </div>
          </form>
          <div class="EmailBottom">
            Back to
            <a href="login.php" id="loginLink">Login</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
