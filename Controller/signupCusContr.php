<?php

//session_start();

class SignupCusContr extends Controller
{
    private $name;
    private $username;
    private $password_1;
    private $password_2;
    private $signupCus;

    public function __construct($name, $username, $password_1, $password_2)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password_1 = $password_1;
        $this->password_2 = $password_2;
        $this->signupCus = new SignupCus();
    }
    public function getErrorsArr()
    {
        $errors = array();
        // form validation: ensure that the form is correctly filled
        // by adding (array_push()) corresponding error unto $errors array
        if (strlen($this->username) < 1) {
            array_push($errors, "Username is required");
        }
        if (strlen($this->name) < 1) {
            array_push($errors, "Name is required");
        }
        if (strlen($this->password_1) < 1) {
            array_push($errors, "Password is required");
        } else {
            if (strlen($this->password_1) < 6) {
                array_push($errors, "Password must be at least 6 charactors long");
            } else {
                if ($this->password_1 != $this->password_2) {
                    array_push($errors, "The two passwords do not match");
                }
            }
        }
        if ($this->signupCus->isUser($this->username)) {
            array_push($errors, "Username already exists");
        }
        $_SESSION['errors'] = $errors;
        return $errors;
    }

    public function signupCustmr()
    {
        // Finally, register user if there are no errors in the form
        if (count($this->getErrorsArr()) == 0) {
            $verificationCode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $mailSender = new MailSender();
            $mailSender->sendMail($this->username, $this->name, $verificationCode);
            if (!isset($_SESSION['mailError'])) {
                $this->signupCus->signup($this->username, $this->password_1, $this->name, $verificationCode);
                $_SESSION['username'] = $this->username;
                $_SESSION['name'] = $this->name;
                $_SESSION['type'] = 'customer';
                //$_SESSION['success'] = "You are now logged in";
                header("Location: ../verifyMail.php?username=" . $this->username);
                unset($_SESSION['mailError']);
                exit();
            }
        }
    }
}
