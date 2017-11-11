<!-- if you need user information, just put them into the $_SESSION variable and output them here -->

Hey, <?php echo $_SESSION['user_email']; ?>. You are logged in.
Try to close this browser tab and open it again. Still logged in! ;)

<?php
include_once("speedreader_new.php");


    return $users;
?>

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->


