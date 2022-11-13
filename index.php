<?php
require "./inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$json = file_get_contents('php://input');
$array=json_decode($json,true);
$requestMethod = $_SERVER["REQUEST_METHOD"];
if (strtoupper($requestMethod) == 'OPTIONS'){
    header('Access-control-allow-origin: http://localhost:3000');
}
else {
    if ((isset($uri[3]) && $uri[3] == 'user') && isset($uri[4])) { //user gateway
        require PROJECT_ROOT_PATH."/Controller/Api/UserController.php";
        $objFeedController = new UserController();
        $strMethodName = $uri[4].'Action';
        $objFeedController->{$strMethodName}($array);
    }
    elseif ((isset($uri[3]) && $uri[3] == 'dm') && isset($uri[4])){ //dm gateway
        require PROJECT_ROOT_PATH."/Controller/Api/Dmcontroller.php";
        $objFeedController = new DmController();
        $strMethodName = $uri[4].'Action';
        $objFeedController->{$strMethodName}($array);
    }
    elseif ((isset($uri[3]) && $uri[3] == 'session') && isset($uri[4])) {  // session gateway
        require PROJECT_ROOT_PATH."/Controller/Api/Sessioncontroller.php";
        $objFeedController = new SessionController();
        $strMethodName = $uri[4].'Session';
        $objFeedController->{$strMethodName}($array);
    }
    else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
}
 

?>