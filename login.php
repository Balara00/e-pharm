<?php
session_start();


// if(isset($_SESSION["username"]))
// {
//  header("location:landing.php");
// }
// include_once "pdo.php";
//
// if(isset($_POST['password']) && isset($_POST['username'])) {
//   if (strlen($_POST['username']) < 1 || strlen($_POST['password']) < 1) {
//
//     $_SESSION['error'] = "Username and password are required";
//     header("Location: login.php");
//     return;
//   }
//
//   $check = md5($_POST['password']);
//   $username = $_POST['username'];
//   $password = $_POST['password'];
//   //$check = hash('md5', $salt.$_POST['pass']);
//   $stmt = $pdo->prepare('SELECT customerID, name FROM customer WHERE username = :un AND password = :pw');
//   $stmt->execute(array( ':un' => $_POST['username'], ':pw' => $check));
//   $row = $stmt->fetch(PDO::FETCH_ASSOC);
//
//   $stmt2 = $pdo->prepare('SELECT pharmacyID, name FROM pharmacy WHERE username = :un AND password = :pw');
//   $stmt2->execute(array( ':un' => $_POST['username'], ':pw' => $check));
//   $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
//
//   if ( $row !== false OR $row2 !== false) {
//     if(isset($_POST['RememberMe'])){
//       setcookie ("username",$username,time()+ (10 * 365 * 24 * 60 * 60));
//       setcookie ("password",$password,time()+ (10 * 365 * 24 * 60 * 60));
//
//       //header("Location: landing.php?customerID=".$_GET['customerID']);
//     }
//     else{
//       if(isset($_COOKIE["username"])){
//         setcookie ("username","");
//       }
//       if(isset($_COOKIE["password"])){
//         setcookie ("password","");
//       }
//       //header("Location: landing.php?customerID=".$_GET['customerID']);
//     }
//     $_SESSION["customerID"] = $row['customerID'];
//     $_SESSION["username"] = $username;
//     header("Location: landing.php?customerID=".$row['customerID']);
//   }
//   else {
//     $_SESSION['error']  = "Incorrect username or password";
//       header("Location: login.php");
//       return;
//   }
//
// }
//

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <title>E-Pharm Login</title>
</head>

<body>
    <div class="MiddleBg">
        <h1 id="epharm">E-Pharm</h1>
        <div class="LoginForm">
          <div class="Welcome">
            <h3 id="note">Welcome Back!</h3>
          </div>
          <div class="error">
            <?php
              if(isset($_SESSION['error']) ) {
                echo('<p style="color:red;
                text-align: center;
                font-family: Ubuntu;
                position: relative;

                ">'.htmlentities($_SESSION['error'])."</p>\n");
                unset($_SESSION['error']);
              }
              ?>
              <?php
                if(isset($_SESSION['success']) ) {
                  echo('<p style="color:#1b93c7;
                  text-align: center;
                  font-family: Ubuntu;
                  position: relative;

                  ">'.htmlentities($_SESSION['success'])."</p>\n");
                  unset($_SESSION['success']);
                }
                ?>
          </div>
          <div class="Form">
            <form method="post" action="includes/login.inc.php">
              <div class="TextInput">
                <img src="assets/icons/UserIcon.svg" >
                <!-- <?php echo "cookie uid ".$_COOKIE['username'];?> -->
                <input type="text" name="username"
                value="<?php if(isset($_COOKIE['username'])) { echo $_COOKIE['username']; } ?>"
                placeholder="username (email address)" required>
              </div>
              <div class="WhiteSpace">
              </div>
              <div class="TextInput">
                <img src="assets/icons/passwordIcon.svg" alt="">
                <input type="password" name="password"
                value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>"
                placeholder="password" required>
              </div>
              <div class="WhiteSpace">
              </div>
              <div class="ForgetPw">
                <a href="forgetPassword.php" id="forgetPwLink">Forget Password?</a>
              </div>

              <div class="WhiteSpace">
              </div>
              <!-- <div class="CheckInput">
                <input class="form-check-input" type="checkbox" id="autoSizingCheck" name='RememberMe'
                <?php if(isset($_COOKIE["username"])) { ?> checked <?php } ?> />
                <label >
                  Remember me
                </label>

              </div> -->
              <!-- <div class="WhiteSpace">
              </div> -->
              <div class="LoginBtn">
                <button type="submit" class="btn" name="login_user">Log In</button>
              </div>
            </form>
            <div class="LoginBottom">
              Don't have an account?
              <a href="signUpCus.php" id="signUpLink">Sign Up</a> <br>
              Haven't register your pharmacy yet?
              <a href="signUpPharm.php" id="signUpLink">Register</a> <br>
            </div>
          </div>
        </div>
    </div>
</body>
</html>
