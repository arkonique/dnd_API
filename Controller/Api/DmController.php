<?php

class DmController extends BaseController
{
    /**
     * /dm/codes
     */
    public function codesAction(){
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $userModel = new UserModel('dms');
                $arrUsers = $userModel->listUsers('dmcode');
                $arrUsers=array_map(function($v){return $v['dmcode'];},$arrUsers); // convert returned objects into one list
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