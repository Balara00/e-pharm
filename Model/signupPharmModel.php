<?php

class SignupPharm
{
    public function isUser($username)
    {
        $pdo = DBConnection::getInstance()->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM customer WHERE username=:temp");
        $stmt->execute([':temp' => strtolower($username)]);
        $user = $stmt->fetch();
        if ($user) { // if user exists
            if (strtolower($user['username']) === strtolower($username)) {
                return true;
            }
        }
        $stmt = $pdo->prepare("SELECT * FROM pharmacy WHERE username=:temp");
        $stmt->execute([':temp' => strtolower($username)]);
        $user = $stmt->fetch();
        if ($user) { // if user exists
            if (strtolower($user['username']) === strtolower($username)) {
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
            ':username' => strtolower($username),
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

        $stmt = $pdo->prepare("SELECT * FROM pharmacy WHERE username=:temp");
        $stmt->execute([':temp' => strtolower($username)]);
        $user = $stmt->fetch();
        if ($user) { // if user exists
            $pharmID = $user['pharmacyID'];
        }

        $query = "INSERT INTO rating_pharmacy (pharmacyID, totalRating, noOfReviews, averageRating) 
        VALUES(:pharmacyID,:totalRating,:noOfReviews,:averageRating)";
        $pdo = DBConnection::getInstance()->getPDO();
        print_r($pdo);
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(
            ':pharmacyID' => $pharmID,
            ':totalRating' => '0',
            ':noOfReviews' => '0',
            ':averageRating' => '0',
        ));

    }
}
