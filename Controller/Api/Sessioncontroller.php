<?php
    class SessionController extends BaseController {
        /**
         * "session/set" endpoint - start session
         */
        public function setSession($arr){
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            if (strtoupper($requestMethod) == 'POST') {
                try {
                    session_start();
                    $_SESSION['username'] = $arr['username'];
                    $responseData = json_encode("SESSION username has been set to ".$_SESSION['username']);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            } 
    
            else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
     
            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json','Access-control-allow-origin: http://localhost:3000','Access-Control-Allow-Credentials: true', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json','Access-control-allow-origin: http://localhost:3000', $strErrorHeader)
                );
            }
        }

        /**
         * "session/get" endpoint - check if session is set
         */
        public function getSession(){
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            if (strtoupper($requestMethod) == 'GET') {
                try {
                    session_start();
                    print json_encode($_SESSION);
                    $responseData = json_encode((isset($_SESSION["username"])) ? $_SESSION["username"]:"No ongoing session");
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            } 
    
            else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
     
            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json','Access-control-allow-origin: http://localhost:3000', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json','Access-control-allow-origin: http://localhost:3000','Access-Control-Allow-Credentials: true', $strErrorHeader)
                );
            }
        }

        public function unsetSession()
        {
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            if (strtoupper($requestMethod) == 'GET') {
                try {
                    session_destroy();
                    $responseData = json_encode("Session killed");
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            } 
    
            else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
     
            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json','Access-control-allow-origin: http://localhost:3000', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json','Access-control-allow-origin: http://localhost:3000', $strErrorHeader)
                );
            }
        }
    }
?>