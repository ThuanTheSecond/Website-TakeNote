<?php
include(".\utils\utils.php");
include(".\db\dbhelper.php");
$name = $pass  = '';
$_SESSION['message'] = '';
if (isset($_POST["login"])) {
    session_start();
    if (isset($_POST["username"]))
        $name = getPost("username");
    if (isset($_POST["password"]))
        $pass = getPost("password");

    $sql = "select * from account where acc_username = '$name' && acc_password = '$pass'";
    $result = executeSelect($sql, isSingleLine: true);
    if ($result == null) {
        // $_SESSION['message'] = "Login Failed. User not found!";
        $_SESSION['message'] = '<span class="errlogin">Login Failed. User not found!</span>';
    } else {
        if (isset($_POST['remember'])) {
            //set up cookies
            setcookie('user', $result['acc_username'], time() + (60 * 10));
            setcookie('pass', $result['acc_password'], time() + (60 * 10));
        }
        $_SESSION['id'] = $result['acc_id'];
        header("Location:.\home\home.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TakeNote</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

   
    <link rel="stylesheet" type="text/css" href="../users/loginFormat.css">
</head>

<body style="background-color: beige;">
    <div class="form-popup" id="userform">
        <h2 class="sign_title">Sign in</h2>
        <form action="" method="post" id="loginform">
            <div class="form-group">
                <div class="form-group form-group-sm">
                    <label for="username" class="formlabel"><b>Username</b></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required value="<?php if (isset($_COOKIE['user'])) {
                                                                                                                                                echo $_COOKIE['user'];
                                                                                                                                            } ?>">
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <label for="password" class="formlabel"><b>Password</b></label>
                    <div class="col-sm-3"><input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required value="<?php if (isset($_COOKIE['pass'])) {
                                                                                                                                                                        echo $_COOKIE['pass'];
                                                                                                                                                                    } ?>" size="35">
                    </div>
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input type="checkbox" checked="checked" name="remember" class="form-check-input" value="Yes">Remember me
                    </label>
                </div>
                <input type="submit" value="Login" name="login" class="btn btn-primary btnlogin">
                <br>
                <span> <?php if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            $_SESSION['message'] = '';
                        }
                        ?> </span><br>
                <a href="users\sign-up.php" class="swlogout" id="swpopup">Don't have account yet? Sign up</a>
            </div>
        </form>
    </div>
</body>

</html>