<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="form_styling.css">
    <title>Speed Reader</title>
</head>
<body>
<!-- login form box -->
<!--<form method="post" action="index.php" name="loginform">-->
<!---->
<!--    <label for="login_input_user_email">Email</label>-->
<!--    <input id="login_input_user_email" name="user_email" required />-->
<!---->
<!--    <label for="login_input_password">Password</label>-->
<!--    <input id="login_input_password" name="user_password" autocomplete="off" required />-->
<!---->
<!--    <input type="submit"  name="login" value="Log in" />-->
<!---->
<!--</form>-->



<!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
<div class="container" style="width: 450px; margin-top: 50px">
    <h3>Speed Reader</h3>
    <div class="card card-container">

        <img id="profile-img" style="margin-left: 25px"class="profile-img-card" src="https://images6.moneysavingexpert.com/images/img-broadband_speed_test.png" />
        <form method="post"   action="index.php" name="loginform" class="form-signin">
            <span id="reauth-email" class="reauth-email"></span>
            <div style="padding: 5px">
                <input id="login_input_user_email" name="user_email" required class="form-control" placeholder="Email address" autofocus style="padding: 5px">
            </div>
            <div style="padding: 5px">
                <input id="login_input_password" name="user_password" type="password"  autocomplete="off" required class="form-control" placeholder="Password" required>
            </div>

            <div id="remember" class="checkbox">

            </div>
            <button class="btn btn-primary btn-block btn-signin" type="submit" name="login">Sign in</button>

        </form><!-- /form -->
        <a href="#" class="forgot-password">
            Forgot the password?
        </a>
        <a href="register.php">Register new account</a>
    </div><!-- /card-container -->
</div><!-- /container -->
</body>
</html>
