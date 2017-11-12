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
            }, 60 / readSpeed* 1000);

        }
    };

    // ajax call using jQuery
    var onStartClick = function () {
        console.log('inside on start click');
        getLineFromDB();
        console.log("onStart currentLineID" + currentLineID);

    };


    var onPauseClick = function () {
        console.log("onPause currentLineID" + currentLineID);
        clearInterval(intervalBetweenWordDisplay);

    };

    var onLogoutClick = function () {
        console.log("onLogoutClick currentLineID" + currentLineID);
        console.log("onLogoutClick currentLineID" + readSpeed);

        document.cookie = 'user_read_speed=' + readSpeed
        document.cookie = 'user_book_line_id=' + currentLineID;

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


    var onChangeReadSpeedClick = function (e) {
        readSpeed = $(e.target).text();
        document.cookie = 'user_read_speed=' + $(e.target).text();

        $("#readSpeedBtn").text("Read Speed " + readSpeed);

        console.log(document.cookie);
    };

    /**
     *
     * -	every time the user changes the speed,
     PHP must respond to an AJAX request, and save the new speed.
     The response is unimportant,
     but send one anyways!
     */


    var currentLine;
    var readSpeed;
    var currentWord;
    var startBtn;
    var pauseBtn;
    var logoutBtn;
    var delayBetweenWords;
    var currentLineAsArray;
    var intervalBetweenWordDisplay;
    var currentLineID;
    var readSpeedDropDown;

    var init = function () {

        currentLine = 'this is some sample text to run through in order to test the speed reader.';
        readSpeed = 100;
        startBtn = document.getElementById('startBtn');
        pauseBtn = document.getElementById('pauseBtn');
        currentWord = document.getElementById('currentWord');
        readSpeedDropDown = document.getElementById('readSpeedDropDown');
        logoutBtn = document.getElementById('logoutBtn')
        delayBetweenWords = 1000; // 1 second for delay to start;
        currentLineID = 1;

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
            logoutBtn.addEventListener('click', onLogoutClick, false);
        }
    };
    return {
        init: init

    };
})();

window.onload = speedReader.init;
