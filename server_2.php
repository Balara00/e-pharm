<?php
include_once "pdo.php";

if (isset($_POST["verify_email"])) {
    $username = $_POST["username"];
    $verificationCode = $_POST["verificationCode"];

    $stmt = $pdo->prepare("SELECT * FROM customer WHERE username=:temp");
    $stmt->execute([':temp' => $username]);
    $user = $stmt->fetch();
    if ($user) { // if user exists
        if ($user['verificationCode'] === $verificationCode) {
            $sql = "UPDATE customer SET verifyingStatus=:verifyingStatus WHERE username=:username";
            $pdo->prepare($sql)->execute(array(
                ':verifyingStatus' => "verified",
                ':username' => $username,
            ));
            header("Location: login.php");
        } else {
            $_SESSION['error'] = 'Verification failed! Please try again..';
            //header("Location: emailVerification.php?username=" . $username);
        }
    }
}
