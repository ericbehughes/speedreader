

<?php
if (isset($_SESSION['user_read_speed']) && isset($_SESSION['user_book_line_id'])) {
    setcookie("user_read_speed", $_SESSION['user_read_speed']);
    setcookie("user_book_line_id", $_SESSION['user_book_line_id']);
}
?>


<?php //ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Speed Reader</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->

    <link rel="stylesheet" href="views/form_styling.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Speed Reader</title>
    <script type="text/javascript" src="./views/speedreader.js"></script>

</head>

<body>

<div id="mainDiv" class="container" style="padding: 0">

    <div class="card card-container" style="width:700px;height: 400px;">
        <span>Hey, <?php echo $_SESSION['user_email']; ?>. You are logged in.</span><br>
        <span>read speed <?php echo $_SESSION['user_read_speed']; ?>. </span><br>
        <span>line id<?php echo $_SESSION['user_book_line_id']; ?>. </span>
        <a id="logoutBtn" href="index.php?logout">Logout</a>
        <br>

        <div>
        <div style="margin-left: 140px;padding: 50px">
            <span id="leftPart" style="font-size: 40px;font-family: monospace"></span>
            <span id="middlePart"  style="font-size: 40px;font-family: monospace; color: red"></span>
            <span id="rightPart" style="font-size: 40px;font-family: monospace;"></span>
        </div>

        <div style="margin: auto;display: flex; align-items: center; justify-content: center;">
            <button id="startBtn" class="btn btn-success">Start</button>
            <button id="pauseBtn" class="btn btn-warning">Pause</button>
            <div class="dropdown" >
                <button class="btn btn-primary dropdown-toggle" id="readSpeedBtn" type="button" data-toggle="dropdown">Read Speed
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" id="readSpeedDropDown" style="    height: auto;max-height: 100px;overflow-x: hidden;">
                    <?php for ($i = 50; $i <= 2000; $i += 50){
                        echo '<li><a href="#">' . $i . '</a></li>';
                    }?>
                </ul>


            </div>
        </div>

    </div>
</div>
</div>
</body>
</html>
