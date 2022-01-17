<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class MailSender
{
    public function sendMail($username, $name, $verificationCode)
    {
        //Instantiation and passing `true` enables exceptions
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
            //echo $username;
            //echo $name;
            //Add a recipient
            $mail->addAddress($username, $name);


            //Set email format to HTML
            $mail->isHTML(true);

            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verificationCode . '</b></p>';

            $mail->send();
            //echo 'Message has been sent';

        } catch (Exception $e) {
            $_SESSION['mailError'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
