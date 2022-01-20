<?php

class SignupCus
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getPDO();
    }
    public function isUser($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customer WHERE username=:temp");
        $stmt->execute([':temp' => $username]);
        $user = $stmt->fetch();
        if ($user) {
            if ($user['username'] === $username) {
                return true;
            }
        }
        $stmt = $this->pdo->prepare("SELECT * FROM pharmacy WHERE username=:temp");
        $stmt->execute([':temp' => $username]);
        $user = $stmt->fetch();
        if ($user) { // if user exists
            if ($user['username'] === $username) {
                return true;
            }
        }

        return false;
    }
    public function signup($username, $password_1, $name, $verificationCode)
    {
        // echo $username . '<br>';
        // echo $password_1 . '<br>';
        // echo $name . '<br>';
        // echo $verificationCode . '<br>';
        $password = md5($password_1); //encrypt the password before saving in the database
        $query = "INSERT INTO customer (username,password,address,name,isActive,verificationCode,verifyingStatus,contactNo) 
        VALUES(:username,:password,:address,:name,:isActive,:verificationCode,:verifyingStatus,'')";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(array(
            ':username' => $username,
            ':password' => $password,
            ':address' => "",
            ':name' => $name,
            ':isActive' => true,
            ':verificationCode' => $verificationCode,
            ':verifyingStatus' => "pending",

        ));
    }
}
