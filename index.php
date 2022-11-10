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
    if ((isset($uri[3]) && $uri[3] == 'user') && isset($uri[4])) {
        require PROJECT_ROOT_PATH."/Controller/Api/UserController.php";
        $objFeedController = new UserController();
        $strMethodName = $uri[4].'Action';
        $objFeedController->{$strMethodName}($array);
    }
    else {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
}
 

?>