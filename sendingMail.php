<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
include_once "pdo.php";
session_start();
$mail = new PHPMailer(true);
try {
    //Enable verbose debug output
    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

    //Send using SMTP
    $mail->isSMTP();

    //Set the SMTP server to send through
    $mail->Host = 'smtp.gmail.com';

    //Enable SMTP authentication
    $mail->SMTPAuth = true;

    //SMTP username
    $mail->Username = 'ktst428@gmail.com';

    //SMTP password
    $mail->Password = '*AbbbbbA*';

    //Enable TLS encryption;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('ktst428@gmail.com', 'E-Pharm');
    $username = $_SESSION['username'];
    $name = $_SESSION['name'];
    //Add a recipient
    $mail->addAddress($username, $name);


    //Set email format to HTML
    $mail->isHTML(true);

    $verificationCode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    $mail->Subject = 'Email verification';
    $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verificationCode . '</b></p>';

    $mail->send();
    $_SESSION['success'] = 'Verification code has been resent!';
    $sql = "UPDATE customer SET verificationCode=:verificationCode WHERE username=:username";
    $pdo->prepare($sql)->execute(array(
        ':verificationCode' => $verificationCode,
        ':username' => $username,
    ));
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
header("Location: emailVerification.php?username=" . $username);
