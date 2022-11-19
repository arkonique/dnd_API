<?php
define("PROJECT_ROOT_PATH",realpath(dirname(__DIR__)));
// include main configuration file
require_once  PROJECT_ROOT_PATH."/inc/config.php";
 
// include the base controller file
require_once  PROJECT_ROOT_PATH."/Controller/Api/Basecontroller.php";
 
// include the model files
require_once PROJECT_ROOT_PATH."/Model/Users.php";
require_once PROJECT_ROOT_PATH."/Model/Chars.php";
?>