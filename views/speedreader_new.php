

<?php
setcookie("user_read_speed", $_SESSION['user_read_speed']); ?>
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

    <div class="card card-container" style="width:700px">
        <span>Hey, <?php echo $_SESSION['user_email']; ?>. You are logged in.</span>
        <a href="index.php?logout">Logout</a>
        <br>

        <div style="width: 500px; height: 300px; margin: auto;display: flex; align-items: center; justify-content: center;">

            <span id="currentWord" style="font-size: 40px">suh</span>
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
