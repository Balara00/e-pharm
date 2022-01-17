<?php

class ResendMailContr extends Controller

{
    private $resendMail;
    public function __construct()
    {
        $this->resendMail = new ResendMail();
    }

    public function resendMail($username, $name)
    {
        $verificationCode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $mailSender = new MailSender();
        $mailSender->sendMail($username, $name, $verificationCode);
        $_SESSION['success'] = 'Verification code has been resent!';
        $this->resendMail->changeCode($username, $verificationCode);
        header("Location: ../verifyMail.php?username=" . $username);
    }
}
