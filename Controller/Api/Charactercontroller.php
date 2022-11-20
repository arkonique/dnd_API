<?php

class CharacterController extends BaseController {
    /**
     * "/characters/list" Endpoint - List all characters for user
     */
    public function listAction($arr)
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $userModel = new CharacterModel('char_personal');
                $arrUsers = $userModel->getData($arr['token']);
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
     * "/characters/get" Endpoint - Get a specific character
     */
    public function getAction($arr){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {

                $userModel = new CharacterModel('char_personal');
                $arrUsers = [$userModel->getChar($arr['srno'])];

                $classModel = new CharacterModel('char_classes');
                $arrUsers[] = $classModel->getData($arr['srno']);

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
}

?>