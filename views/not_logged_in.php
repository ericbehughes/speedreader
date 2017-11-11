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
    <link rel="stylesheet" href="views/form_styling.css">
    <title>Speed Reader</title>
</head>
<body>
<div class="container" style="margin-top: 50px">

    <div class="card card-container">

        <img id="profile-img" class="profile-img-card" src="https://images6.moneysavingexpert.com/images/img-broadband_speed_test.png" />
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
        <a class="forgot-password"href="register.php">Register new account</a>
    </div><!-- /card-container -->
</div><!-- /container -->
</body>
</html>
