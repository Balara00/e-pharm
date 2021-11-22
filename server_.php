<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
//Load Composer's autoloader
require 'vendor/autoload.php';
include_once "pdo.php";


$username = "";
$name = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive input values from the form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password_1 = $_POST['password_1'];
    $password_2 =  $_POST['password_2'];

    // form validation: ensure that the form is correctly filled
    // by adding (array_push()) corresponding error unto $errors array
    if (strlen($username) < 1) {
        array_push($errors, "Username is required");
    }
    if (strlen($name) < 1) {
        array_push($errors, "Name is required");
    }
    if (strlen($password_1) < 1) {
        array_push($errors, "Password is required");
    } else {
        if (strlen($password_1) < 6) {
            array_push($errors, "Password must be at least 6 charactors long");
        } else {
            if ($password_1 != $password_2) {
                array_push($errors, "The two passwords do not match");
            }
        }
    }


    $stmt = $pdo->prepare("SELECT * FROM customer WHERE username=:temp");
    $stmt->execute([':temp' => $username]);
    $user = $stmt->fetch();
    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database
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
            echo $username;
            echo $name;
            //Add a recipient
            $mail->addAddress($username, $name);


            //Set email format to HTML
            $mail->isHTML(true);

            $verificationCode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verificationCode . '</b></p>';

            $mail->send();
            //echo 'Message has been sent';

            $query = "INSERT INTO customer (username,password,address,name,isActive,verificationCode,verifyingStatus) 
  			  VALUES(:username,:password,:address,:name,:isActive,:verificationCode,:verifyingStatus)";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(
                ':username' => $username,
                ':password' => $password,
                ':address' => "",
                ':name' => $name,
                ':isActive' => true,
                ':verificationCode' => $verificationCode,
                ':verifyingStatus' => "pending",

            ));

            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            //$_SESSION['success'] = "You are now logged in";
            header("Location: emailVerification.php?username=" . $username);
        } catch (Exception $e) {
            $_SESSION['mailError'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
