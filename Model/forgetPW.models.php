<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// require 'C:/laragon/bin/php/phpMailer/vendor/autoload.php';
require '../vendor/autoload.php';

class ForgetPW{
    public function sendUserMail($email){

        $dbc = DBConnection::getInstance();
        $pdo = $dbc->getPDO();
        
        $customerStmt = $pdo->prepare("SELECT * FROM customer where username = :xyz");
        $customerStmt->execute(array(":xyz" => $email));
        $customerRow = $customerStmt->fetch(PDO::FETCH_ASSOC);
        if ( $customerRow === false ) {
            $_SESSION['error'] = 'Incorrect Email Address';
            header( 'Location: forgetPassword.php' ) ;
            return;
        }

        $mail = new PHPMailer(true);

        try{
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
        
            //Send using SMTP
            $mail->isSMTP();
        
            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';
        
            //Enable SMTP authentication
            $mail->SMTPAuth = true;
        
            //SMTP username
            $mail->Username = 'epharm.quaranteam@gmail.com';
            // $mail->Username = 'daruvindid99@gmail.com';
        
            //SMTP password
            $mail->Password = 'quaranteam@1';
            // $mail->Password = 'ru4620dil7068';
        
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;
        
            //Recipients
            $mail->setFrom('epharm.quaranteam@gmail.com', 'E-Pharm');
        
            //Add a recipient
            $mail->addAddress($email);
        
            //Set email format to HTML
            $mail->isHTML(true);
        
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        
            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
        
            $mail->send();
            // echo 'Message has been sent';
            $customerSql = "UPDATE customer SET verificationCode = $verification_code WHERE username = :email";
            $customerStmt = $pdo->prepare($customerSql);
            $customerStmt->execute(array(':email' => $email));
        
            header("Location: ../verifyCode.php?email=".$email);
        
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}