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
    var getCurrentWord = function () {

        var i = 0;
            intervalBetweenWordDisplay = setInterval(function () {
                if (i < currentLineAsArray.length ) {
                    currentWord.textContent = currentLineAsArray[i];
                    console.log(i);
                    i++;
                }

                if (i == currentLineAsArray.length){
                    i = 0;
                    ++currentLineID;
                    getLineFromDB();
                }

            }, 60 / readSpeed* 1000);



    };

    // ajax call using jQuery
    var onStartClick = function () {
        console.log('inside on start click');

        getLineFromDB();
        console.log(currentLine);
        console.log("onStart currentLineID " + currentLineID);

    };


    var onPauseClick = function () {
        clearInterval(intervalBetweenWordDisplay);
        console.log("onPause currentLineID" + currentLineID);
        updateBookIDAndReadSpeed();


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
                currentLine = msg;
                currentLineAsArray = currentLine.split(" ");


            },
            error: function (xhr, status, errorThrown) {

                alert("Sorry, there was a problem retrieving the book!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            }

        });
    };


    var updateSpeedToDB = function (){
        $.ajax({
            type: "GET",
            url: "book.php",
            data: 'speed='+readSpeed,
            dataType: "html",
            success: function (msg) {

                console.log('updated db with new speed successful ');

            },
            error: function (xhr, status, errorThrown) {

                alert("Sorry, there was a problem retrieving the book!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            }

        });
    };


    var onChangeReadSpeedClick = function (e) {
        readSpeed = $(e.target).text();
        document.cookie = 'user_read_speed=' + $(e.target).text();
        clearInterval(intervalBetweenWordDisplay);
        $("#readSpeedBtn").text("Read Speed " + readSpeed);
        updateSpeedToDB();
        updateBookIDAndReadSpeed();
        console.log(document.cookie);
    };

    var updateBookIDAndReadSpeed = function () {
        console.log(document.cookie);
        document.cookie = 'user_read_speed=' + readSpeed
        document.cookie = 'user_book_line_id=' + currentLineID;
    };

    var getLineIDAndReadSpeedFromCookie = function(){
        if (document.cookie.indexOf("user_read_speed") !== -1){
            var keyIndex = document.cookie.indexOf("user_read_speed");
            var semiColon = document.cookie.indexOf(";", keyIndex);
            var str = document.cookie.substring(keyIndex + "user_read_speed".length +1, semiColon);
            readSpeed = str;
        }

        if (document.cookie.indexOf("user_book_line_id") !== -1){
            var keyIndex = document.cookie.indexOf("user_book_line_id");
            var semiColon = document.cookie.indexOf(";", keyIndex);
            var str = document.cookie.substring(keyIndex + "user_book_line_id".length +1, semiColon);
            currentLineID = str;
        }
        else{
            readSpeed = 100;
            currentLineID=1;
        }
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
    var currentLineAsArray;
    var intervalBetweenWordDisplay;
    var currentLineID;
    var readSpeedDropDown;
    var lockedOutSpan;

    var init = function () {

        currentLine = 'this is some sample text to run through in order to test the speed reader.';
        readSpeed = 100;
        startBtn = document.getElementById('startBtn');
        pauseBtn = document.getElementById('pauseBtn');
        currentWord = document.getElementById('currentWord');
        readSpeedDropDown = document.getElementById('readSpeedDropDown');
        logoutBtn = document.getElementById('logoutBtn');

        currentLineID = 1;

        // Add event handlers
        if (document.addEventListener) {
            startBtn.addEventListener('click', onStartClick, false);
            pauseBtn.addEventListener('click', onPauseClick, false);
            readSpeedDropDown.addEventListener('click', onChangeReadSpeedClick, false);
            logoutBtn.addEventListener('click', onLogoutClick, false);
            getLineIDAndReadSpeedFromCookie();
        }

        $("#readSpeedBtn").text("Read Speed " + readSpeed);
        getLineFromDB();
        getCurrentWord();
        $(currentWord).text()




    };
    return {
        init: init

    };
})();

window.onload = speedReader.init;
