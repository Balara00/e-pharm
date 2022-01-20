<?php

class MailVerifyContr extends Controller
{
    private $username;
    private $verificationCode;
    private $mailVerify;
    private $type;

    public function __construct($username, $verificationCode, $type)
    {
        $this->username = $username;
        $this->verificationCode = $verificationCode;
        $this->mailVerify = new MailVerification();
        $this->type = $type;
    }

    public function verify()
    {
        $user = $this->mailVerify->getUser($this->username, $this->type);
        if ($user) { // if user exists
            if ($user['verificationCode'] === $this->verificationCode) {
                $this->mailVerify->verifyMail($this->username, $this->type);
                header("Location: ../login.php");
                exit();
            } else {
                echo 'j';
                $_SESSION['error'] = 'Verification failed! Please try again..';
                header("Location: ../verifyMail.php?username=" . $this->username);
            }
        }
    }
}
