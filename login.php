<?php
session_start();
include_once "pdo.php";


$salt = 'XyZzy12*_';

if(isset($_POST['pass']) && isset($_POST['username'])) {

    if (strlen($_POST['username']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "Username and password are required";
        header("Location: login.php");
        return;
    }

    //$check = hash('md5', $salt.$_POST['pass']);
    $stmt = $pdo->prepare('SELECT customerID, name FROM customer WHERE username = :un AND password = :pw');
    $stmt->execute(array( ':un' => $_POST['username'], ':pw' => $_POST['pass']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ( $row !== false ) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        // Redirect the browser to index.php
        header("Location: index.php");
        return;

    } else {
      $_SESSION['error']  = "Incorrect username or password";
        header("Location: login.php");
        return;
    }

}

//if(isset($_POST['email']) && isset($_POST['pass'])) {
  //
   // }
//}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balara Sawanmee's Login Page</title>
</head>
<body>
    <h1>Please Log In</h1>

    <?php
    if(isset($_SESSION['error']) ) {
        echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    ?>

    <form method="post">
    User Name <input type="text" name="username"><br/>
    Password <input type="password" name="pass" id="id_1723"><br/>
    <input type="submit" value="Log In" onclick="return doValidate();">
    <a href="index.php">Cancel</a>
    </form>

    <script>
        function doValidate() {
            console.log('Validating...');
            try {
                pw = document.getElementById('id_1723').value;
                console.log("Validating pw="+pw);
                if (pw == null || pw == "") {
                    alert("Both fields must be filled out");
                    return false;
                }
                return true;
            } catch(e) {
                return false;
            }
            return false;
            }
    </script>
</body>
</html>
