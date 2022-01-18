<?php

class SignupPharm
{
    public function isUser($username)
    {
        $pdo = DBConnection::getInstance()->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM customer WHERE username=:temp");
        $stmt->execute([':temp' => $username]);
        $user = $stmt->fetch();
        if ($user) { // if user exists
            if ($user['username'] === $username) {
                return true;
            }
        }
        $stmt = $pdo->prepare("SELECT * FROM pharmacy WHERE username=:temp");
        $stmt->execute([':temp' => $username]);
        $user = $stmt->fetch();
        if ($user) { // if user exists
            if ($user['username'] === $username) {
                return true;
            }
        }
        return false;
    }
    public function signup($username, $password_1, $name, $verificationCode, $dvStatus, $dvOrdes, $area, $address, $contactNo)
    {
        echo $username . '<br>';
        echo $password_1 . '<br>';
        echo $name . '<br>';
        echo $verificationCode . '<br>';
        echo $dvStatus . '<br>';
        echo $dvOrdes . '<br>';
        echo $area . '<br>';
        echo $contactNo . '<br>';
        echo $address . '<br>';

        $password = md5($password_1); //encrypt the password before saving in the database

        echo $password;
        $query = "INSERT INTO pharmacy (username,password,name,contactNo,address,area,deliveryServiceStatus,dvOrdersPerDay,isActive,verificationCode,verifyingStatus) 
        VALUES(:username,:password,:name,:contactNo,:address,:area,:dvstatus,:dvOdrs,:isActive,:verificationCode,:verifyingStatus)";
        $pdo = DBConnection::getInstance()->getPDO();
        print_r($pdo);
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(
            ':username' => $username,
            ':password' => $password,
            ':name' => $name,
            ':contactNo' => $contactNo,
            ':address' => $address,
            ':area' => $area,
            ':dvstatus' => $dvStatus,
            ':dvOdrs' => $dvOrdes,
            ':isActive' => true,
            ':verificationCode' => $verificationCode,
            ':verifyingStatus' => "pending",

        ));
    }
}
