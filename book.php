<?php
/**
 * Created by PhpStorm.
 * User: ehugh
 * Date: 11/11/2017
 * Time: 5:39 PM
 */


session_start();
session_regenerate_id();
require_once("classes/Database.php");
$db = new Database();
if ($_GET['id']){
    $id = $_GET['id'];
    $line = $db->getLineById($id);
    while (strlen($line['line']) == 0){
        $line = $db->getLineById(++$id);
    }
    echo $line['line'];
    $_SESSION['user_book_line_id'] = $line['id'];
}
elseif ($_GET['speed']){
    $speed = $_GET['speed'];
    $email = $_SESSION['user_email'];
    $line = $db->updateUserReadSpeed($email, $speed);

}

