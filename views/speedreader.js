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
        currentLineAsArray = currentLine.split(" ");
        var i = 0;
            intervalBetweenWordDisplay = setInterval(function () {
                if (i < currentLineAsArray.length ) {
                    currentWord = currentLineAsArray[i];
                    formatCurrentWordBeforeDisplay();
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
        getCurrentWord();
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

        if (/^([0-9]+)$/.test($(e.target).text())){
            readSpeed = $(e.target).text();
            clearInterval(intervalBetweenWordDisplay);
            console.log('read speed' + readSpeed);
            document.cookie = 'user_read_speed=' + $(e.target).text();
            //clearInterval(intervalBetweenWordDisplay);
            $("#readSpeedBtn").text("Read Speed " + readSpeed);
            updateSpeedToDB();
            updateBookIDAndReadSpeed();
            getLineFromDB();
            getCurrentWord();

            console.log(document.cookie);
        }
        else{
            alert('please enter a valid readspeed between 50-2000');
        }

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
    
    
    var formatCurrentWordBeforeDisplay = function () {
        console.log(currentWord);
        var length = currentWord.length;

        if (length == 1){
            leftPart.textContent = '\u00A0'+'\u00A0'+'\u00A0'+'\u00A0'
            middlePart.textContent = currentWord;
            rightPart.textContent = "";
        }
        else if (length >=2 && length <= 5 ){
            //var a = $(currentWord).text()[2];

            // creates the new html having wrapped the accesskey character with a span
            leftPart.textContent = '\u00A0'+'\u00A0'+'\u00A0'+currentWord.substring(0, 1);
            middlePart.textContent = currentWord[1];
            rightPart.textContent = currentWord.substring(2);

            //$(currentWord).text().css('color', 'red');
        }
        else if (length >= 6 && length <=9){

            //em b assy
            //traveler
            //  tr
            leftPart.textContent = '\u00A0'+'\u00A0'+currentWord.substring(0, 2);
            middlePart.textContent = currentWord[2];
            rightPart.textContent = currentWord.substring(3);
        }
        else if (length >= 10 && length <= 13){

        }
        else if (length > 13){

        }
        else{

        }

    };
        
    

    /**
     * 
     * -	When displaying each token:
     o	choose a monospaced font
     o	have the text left-justified
     o	choose a focus letter based off the length of the token and “center” 
     the word around the focus letter (not really centered, see algorithm below):
     length = 1 => 1st letter    e.g.: ____a or 4 spaces before
     length = 2-5 => 2nd letter  e.g.: ___four or 3 spaces before
     e.g.: ___latch or 3 spaces before
     length = 6-9 => third letter      __embassy 2 spaces
     length = 10-13 => fourth letter   _playground 1 spaces
     length >13 => fifth letter        acknowledgement no spaces

     * 
     * 
     * 
     */

    var currentLine;
    var readSpeed;
    var currentWord;
    var leftPart;
    var middlePart;
    var rightPart;
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
        leftPart= document.getElementById('leftPart');
        middlePart = document.getElementById('middlePart');
        rightPart = document.getElementById('rightPart');
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
        //$(currentWord).text()




    };
    return {
        init: init

    };
})();

window.onload = speedReader.init;
