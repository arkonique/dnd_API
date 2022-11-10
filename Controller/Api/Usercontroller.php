<?php
class UserController extends BaseController
{
    /**
     * "/user/get" Endpoint - Get user with matching username and password
     */
    public function getAction($arr)
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $userModel = new UserModel();
                $username=$arr['u'];
                $password=$arr['p'];
                $arrUsers = $userModel->getUsers($username,$password);
                $responseData = json_encode($arrUsers);
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

    /**
     * "/user/list" Endpoint - Get all usernames
     */

    public function listAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $arrUsers = $userModel->listUsers();
                $arrUsers=array_map(function($v){return $v['username'];},$arrUsers); // convert returned objects into one list
                $responseData = json_encode($arrUsers);
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

    /**
     * "/user/add" Endpoint - Add new user
     */

    public function addAction($arr){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST'){
            $userModel = new UserModel();
            $userModel->addUsers($arr['data']);
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$strErrorDesc) {
            $this->sendOutput(json_encode(["success",'1']),
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