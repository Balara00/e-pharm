<?php

class ForgetPWContr extends ForgetPW{
    private $email;

    public function __construct($email){
        $this->email = $email;
    }

    public function sendMail(){
        $this->sendUserMail($this->email);
    }
}