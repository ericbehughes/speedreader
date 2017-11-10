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
    <title>Document</title>
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
<div class="container" style="width: 450px; margin-top: 100px">
    <div class="card card-container">
        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <img id="profile-img" class="profile-img-card" src="https://images6.moneysavingexpert.com/images/img-broadband_speed_test.png" />
        <p id="profile-name" class="profile-name-card"></p>
        <form method="post"   action="index.php" name="loginform" class="form-signin">
            <span id="reauth-email" class="reauth-email"></span>
            <input id="login_input_user_email" name="user_email" required class="form-control" placeholder="Email address" autofocus>
            <input id="login_input_password" name="user_password" type="password"  autocomplete="off" required class="form-control" placeholder="Password" required>
            <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-sm btn-primary btn-block btn-signin" type="submit">Sign in</button>

        </form><!-- /form -->
        <a href="#" class="forgot-password">
            Forgot the password?
        </a>
        <a href="register.php">Register new account</a>
    </div><!-- /card-container -->
</div><!-- /container -->
</body>
</html>
