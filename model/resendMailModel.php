<?php

class ResendMail
{
    public function changeCode($username, $verificationCode)
    {
        $type = $_SESSION['type'];
        if (!isset($_SESSION['mailError'])) {
            $pdo = DBConnection::getInstance()->getPDO();
            $sql = "UPDATE $type SET verificationCode=:verificationCode WHERE username=:username";
            $pdo->prepare($sql)->execute(array(
                ':verificationCode' => $verificationCode,
                ':username' => $username,
            ));
        }
    }
}
