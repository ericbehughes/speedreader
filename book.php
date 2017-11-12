<?php
/**
 * Created by PhpStorm.
 * User: ehugh
 * Date: 11/11/2017
 * Time: 5:39 PM
 */

require_once("classes/Database.php");
$db = new Database();
if ($_GET['id']){

    $line = $db->getLineById($_GET['id']);
    echo $line;
}

