<?php
include("..\utils\utils.php");
include("..\db\dbhelper.php");
$exist = "";
$_SESSION['message']='';
$username = $password = $confirm = "";
if (isset($_POST['confirm'])) {
    $username = getPost("username");
    $password = getPost("password");
    $confirm = getPost("confpass");
    $exists = false;
}
$sql = "Select * from account where acc_username = '$username'";
$data = executeSelect($sql, isSingleLine: true);
if ($data == null && $username != "") {
    if (($password == $confirm) && $exist == false) {
        $sql = "insert into account(acc_username, acc_password) values
            ('$username', '$password');";
        $result = executeQuery($sql);
        header('Location:..\index.php');
    }
}else if($data!=null){
        $_SESSION['message']='<span class="errlogin">Username is taken!</span>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TakeNote</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../Css/loginFormat.css">
</head>

<body style="background-color: beige;">
    <div class="form-popup" id="userform">
        <h2 class="sign_title">Sign up</h2>
        <span> <?php if (isset($_SESSION['message'])) {
                                            echo $_SESSION['message'];
                                            $_SESSION['message']='';
                                        }
                                        ?> </span><br>
        <form action="" method="post" id="signupform" onsubmit="validpassword()">
            <div class="form-group">
                <div class="form-group form-group-sm">
                    <div id="msgerro" value="<?php if ($exist == false) {
                                                    echo "Username is already taken";
                                                } ?>"></div>
                    <label for="username" class="formlabel"><b>Username</b></label>
                    <input type="text" name="username" class="form-control logout-form" id="username" placeholder="Enter username" required value="<?php if (isset($_POST['username'])) {
                                                                                                                                                        echo $_POST["username"];
                                                                                                                                                    } ?>">
                </div>
                <div class="form-group form-group-sm">
                    <label for="password" class="formlabel"><b>Password</b></label>
                    <input type="password" class="form-control logout-form" name="password" id="password" placeholder="Enter password" required onkeyup="validpassword()">
                </div>
                <div class="form-group form-group-sm">
                    <label for="confpass" class="formlabel"><b>Confirm password</b></label>
                    <input type="password" class="form-control logout-form" name="confpass" id="confpass" placeholder="Enter password" required onkeyup="validpassword()">
                    <span id="msg"></span>
                </div>
                <input type="submit" value="Confirm" id="confirm" name="confirm" class="btn btn-primary btnlogout">
            </div>

        </form>
    </div>
    <script>
        var validpassword = function() {
            var pw1 = document.getElementById("password").value;
            var pw2 = document.getElementById("confpass").value;
            if (pw1 != "" && pw2 != "") {
                if (pw1 == pw2) {
                    document.getElementById('msg').style.color = 'white';
                    document.getElementById('msg').innerHTML = 'matching';
                } else {
                    document.getElementById('msg').style.color = 'red';
                    document.getElementById('msg').innerHTML = 'not matching';
                }
            } else document.getElementById('msg').innerHTML = '';
        }
        document.getElementById('signupform').addEventListener('submit', function() {});
    </script>
</body>

</html>