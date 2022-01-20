<?php

class MailVerification
{
    public function getUser($username, $type)
    {
        $pdo = DBConnection::getInstance()->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM $type WHERE username=:temp");
        $stmt->execute([':temp' => $username]);
        $user = $stmt->fetch();
        return $user;
    }
    public function verifyMail($username, $type)
    {
        $pdo = DBConnection::getInstance()->getPDO();
        $sql = "UPDATE $type SET verifyingStatus=:verifyingStatus WHERE username=:username";
        $pdo->prepare($sql)->execute(array(
            ':verifyingStatus' => "verified",
            ':username' => $username,
        ));
    }
}
