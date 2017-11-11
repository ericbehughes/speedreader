<!-- if you need user information, just put them into the $_SESSION variable and output them here -->

Hey, <?php echo $_SESSION['user_email']; ?>. You are logged in.
Try to close this browser tab and open it again. Still logged in! ;)

<?php
include_once("speedreader_new.php");

    $path = 'http://www.textfiles.com/etext/FICTION/aesop11.txt';
    $file = fopen($path, "r");
    $lines = [];
    $blankLineCount = 0;
    while ($line = fgets($file)) {
        $line = trim($line);
        if (strlen($line) === 0 && $blankLineCount < 1){
            $lines[] = $line;
            $blankLineCount++;
        }
        elseif (strlen($line) > 0){
            $lines[] = $line;
            $blankLineCount = 0;

        }

    }
    fclose($file);

    return $users;
?>

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->


