<?php

//session_start();

class SignupPharmContr extends Controller
{
    private $name;
    private $username;
    private $password_1;
    private $password_2;
    private $signupPharm;
    private $area;
    private $address;
    private $contactNo;
    private $dvStatus;
    private $dvOrders;

    public function __construct($name, $username, $password_1, $password_2, $area, $address, $contactNo, $dvStatus, $dvOrders)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password_1 = $password_1;
        $this->password_2 = $password_2;
        $this->area = $area;
        $this->address = $address;
        $this->contactNo = $contactNo;
        $this->dvStatus = $dvStatus;
        $this->dvOrders = $dvOrders;
        $this->signupPharm = new SignupPharm();
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
        if (strlen($this->area) < 1) {
            array_push($errors, "Area is required");
        }
        if (strlen($this->address) < 1) {
            array_push($errors, "Address is required");
        }
        if (strlen($this->contactNo) < 1) {
            array_push($errors, "Contact number is required");
        } else {
            if (strlen($this->contactNo) != 10 and strlen($this->contactNo) != 9) {
                echo strlen($this->contactNo);
                array_push($errors, "Invalid contact number");
            }
        }
        if ($this->dvStatus) {
            if ($this->dvOrders < 1) {
                array_push($errors, "Number is required");
            }
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
        if ($this->signupPharm->isUser($this->username)) {
            array_push($errors, "Username already exists");
        }
        $_SESSION['errors'] = $errors;
        return $errors;
    }

    public function signupPharm()
    {
        // Finally, register user if there are no errors in the form
        if (count($this->getErrorsArr()) == 0) {
            $verificationCode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $mailSender = new MailSender();
            $mailSender->sendMail($this->username, $this->name, $verificationCode);
            if (!isset($_SESSION['mailError'])) {
                $this->signupPharm->signup($this->username, $this->password_1, $this->name, $verificationCode, $this->dvStatus, $this->dvOrders, $this->area, $this->address, $this->contactNo);
                $_SESSION['username'] = $this->username;
                $_SESSION['name'] = $this->name;
                $_SESSION['type'] = 'pharmacy';
                //$_SESSION['success'] = "You are now logged in";
                header("Location: ../verifyMail.php?username=" . $this->username);
                unset($_SESSION['mailError']);
                exit();
            }
        }
    }
}
