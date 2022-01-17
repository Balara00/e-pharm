<?php
session_start();
//include "../includes/verifyMail.inc.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style_temp.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>Email verification</title>
</head>


<body>
    <div class="center_bg">
        <h2 id="e-pharm">E-Pharm</h2>
        <div class="sign-form" style="height:400px">
            <div class="welcome-container">
                <h3 id="welcome">Verify Your Email!</h3>
            </div>
            <?php
            if (isset($_SESSION['success'])) {
                echo ('<p style="color:#47d147;
                font: size 15px;
                text-align: center;
                font-family: Ubuntu;

                ">' . htmlentities($_SESSION['success']) . "</p>\n");
                unset($_SESSION['success']);
            }
            ?>
            <?php
            if (isset($_SESSION['error'])) {
                echo ('<p style="color:red;
                font-size:15px;
                text-align: center;
                font-family: Ubuntu;

                ">' . htmlentities($_SESSION['error']) . "</p>\n");
                unset($_SESSION['error']);
            }
            ?>
            <div class="form-container">
                <form method="POST" action="includes/verifyMail.inc.php">
                    <input type="hidden" name="username" value="<?php echo $_GET['username']; ?>" required>

                    <div class="input-group" id="field">
                        <img src="icons/verification.svg" alt="">
                        <input type="text" name="verificationCode" placeholder="Enter verification code" required />
                    </div>
                    <div class="signup-btn">
                        <!-- <input type="submit" name="verify_email" value="Verify Email"> -->
                        <button type="submit" class="btn" name="verify_email">Verify</button>
                    </div>
                </form>
                <div class="login-ask">
                    <p>
                        <?php
                        echo 'Want resend the verification code?  <a id="log-link" href="includes/resendMail.inc.php">Resend</a>';
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>