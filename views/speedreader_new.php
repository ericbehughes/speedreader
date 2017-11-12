

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
    <script type="text/javascript">


        /**
         *
         getLineFromDB(): string
         getCurrentWord(): string
         displayCurrentWord() : void
         isPlaying: boolean
         readSpeed: int
         onStopClick
         onPauseClick
         * @type {{init}}
         */
        var speedReader = (function () {
                var onPauseClick = function () {
                    currentWord =
                    clearInterval(intervalBetweenWordDisplay);
                }

                var getCurrentWord = function (currentLine) {
                    currentLineAsArray = currentLine.split(" ");
                    var i = 0;
                    if (typeof currentLine === 'string') {
                        intervalBetweenWordDisplay = setInterval(function () {
                            if (i < currentLineAsArray.length - 1) {
                                currentWord.textContent = currentLineAsArray[i];
                                i++;
                            }
                            else {
                                clearInterval(intervalBetweenWordDisplay);
                                //alert('interval over');
                                ++currentLineID;
                                onStartClick();
                            }
                        }, 500);

                    }
                };

                // ajax call using jQuery
                var onStartClick = function () {
                console.log('inside on start click');
                    getLineFromDB();
                };

               var getLineFromDB = function (){
                    $.ajax({
                        type: "GET",
                        url: "book.php",
                        data: 'id=' + currentLineID,
                        dataType: "html",
                        success: function (msg) {
                            if (msg.toString().length !== 0){
                                currentLine = msg;
                                console.log('success');
                                getCurrentWord(currentLine);

                            }else{
                                ++currentLineID
                                onStartClick();
                            }
                        },
                        error: function (xhr, status, errorThrown) {

                            alert("Sorry, there was a problem retrieving the book!");
                            console.log("Error: " + errorThrown);
                            console.log("Status: " + status);
                            console.dir(xhr);
                        }

                    });
                }


                var resumeReading = function () {

                }
                
                var onChangeReadSpeedClick = function (e) {

                    console.log($(e.target).text());
                    readSpeed = $(e.target).text();
                    document.cookie = 'user_read_speed=' + $(e.target).text();

                    $("#readSpeedBtn").text("Read Speed " + readSpeed);



                };



                    /**
                     *
                     * -	every time the user changes the speed,
                     PHP must respond to an AJAX request, and save the new speed. The response is unimportant,
                     but send one anyways!
                      */


                var currentLine;
                var isPaused;
                var readSpeed;
                var onPauseClick;
                var currentWord;
                var startBtn;
                var pauseBtn;
                var delayBetweenWords;
                var currentLineAsArray;
                var intervalBetweenWordDisplay;
                var currentLineID;
                var readSpeedDropDown;

                var init = function () {

                    currentLine = 'this is some sample text to run through in order to test the speed reader.';
                    isPaused = false;
                    readSpeed = 100;
                    startBtn = document.getElementById('startBtn');
                    pauseBtn = document.getElementById('pauseBtn');
                    currentWord = document.getElementById('currentWord');
                    readSpeedDropDown = document.getElementById('readSpeedDropDown');
                    delayBetweenWords = 1000; // 1 second for delay to start;
                    currentLineID = 0;

                    if (document.cookie.indexOf("user_read_speed") !== -1){
                        var keyIndex = document.cookie.indexOf("user_read_speed");
                        var semiColon = document.cookie.indexOf(";", keyIndex);
                        var str = document.cookie.substring(keyIndex + "user_read_speed".length +1, semiColon);
                        readSpeed = str;
                    }
                    else{
                        readSpeed = 100;
                    }

                    $("#readSpeedBtn").text("Read Speed " + readSpeed);

                    // Add event handlers
                    if (document.addEventListener) {
                        startBtn.addEventListener('click', onStartClick, false);
                        pauseBtn.addEventListener('click', onPauseClick, false);
                        readSpeedDropDown.addEventListener('click', onChangeReadSpeedClick, false);


                    }
                };
                return {
                    init: init

                };
            })();

        window.onload = speedReader.init;

    </script>

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
