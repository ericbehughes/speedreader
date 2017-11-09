<?php

// include the configs / constants for the database connection
require_once("classes/Database.php");
// load the registration class
require_once("classes/Registration.php");
$db = new Database();

// create the registration object. when this object is created, it will do all registration stuff automatically
// so this single line handles the entire registration process.
$registration = new Registration($db);
// show the register view (with the registration form, and messages/errors)
include("views/register.php");
