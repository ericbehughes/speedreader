

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
         *   getLineFromDB(): string
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


                var onStartClick = function () {
                console.log('inside on start click');
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

                            alert("Sorry, there was a problem!");
                            console.log("Error: " + errorThrown);
                            console.log("Status: " + status);
                            console.dir(xhr);
                        }

                    });
                };


                var currentLine;
                var isPaused;
                var readSpeed;
                var onPauseClick;
                var currentWord;
                var getLineFromDB;
                var startBtn;
                var pauseBtn;
                var delayBetweenWords;
                var currentSpaceIndex;
                var currentLineAsArray;
                var intervalBetweenWordDisplay;
                var currentLineID;

                var init = function () {

                    currentLine = 'this is some sample text to run through in order to test the speed reader.';
                    isPaused = false;
                    readSpeed = 100;
                    startBtn = document.getElementById('startBtn');
                    pauseBtn = document.getElementById('pauseBtn');
                    currentWord = document.getElementById('currentWord');
                    delayBetweenWords = 1000; // 1 second for delay to start;
                    currentLineID = 0;

                    // Add event handlers
                    if (document.addEventListener) {
                        startBtn.addEventListener('click', onStartClick, false);
                        pauseBtn.addEventListener('click', onPauseClick, false);

                    }
                };


                return {
                    // Declare public members.

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
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Read Speed
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" style="    height: auto;max-height: 100px;overflow-x: hidden;">
                    <?php for ($i = 50; $i <= 700; $i += 50){
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