<?php
/**
 * Created by PhpStorm.
 * User: ehugh
 * Date: 11/14/2017
 * Time: 7:38 PM
 */

require_once("classes/Database.php");
$db = new Database();
$db->loadLinesIntoBookTable();