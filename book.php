<?php
/**
 * Created by PhpStorm.
 * User: ehugh
 * Date: 11/11/2017
 * Time: 5:39 PM
 */


/**
 * NOTE: in order to keep a speed integer encoded as an integer,
 * use the JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT options with json_encode.
 */
require_once("classes/Database.php");
$db = new Database();
if ($_GET['id']){
    $line = $db->getLineById($_GET['id']);
    echo $line;
}
elseif ($_GET['user_read_speed']){

}

