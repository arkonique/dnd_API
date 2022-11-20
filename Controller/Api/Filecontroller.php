<?php

class FileController extends BaseController
{
    /**
     * "/files/upload" Endpoint - Upload a file
     */
    public function uploadAction($array)
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {
            try {
                // get the file
                $file = $_FILES['file'];
                // get the file name
                $fileName = $file['name'];
                // get the file temp name
                $fileTmpName = $file['tmp_name'];
                // get the file size
                $fileSize = $file['size'];
                // get the file error
                $fileError = $file['error'];
                // get the file type
                $fileType = $file['type'];
                // get the file extension
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                // allowed file extensions
                $allowed = array('jpg', 'jpeg', 'png');
                // check if the file extension is allowed
                if (in_array($fileActualExt, $allowed)) {
                    // check if there are no errors
                    if ($fileError === 0) {
                        // check if the file size is less than 1MB
                        if ($fileSize < 10000000) {
                            // create a unique file name
                            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                            // set the file destination
                            $fileDestination = 'src/img/' . $fileNameNew;
                            // move the file to the destination
                            move_uploaded_file($fileTmpName, $fileDestination);
                            // set the response data
                            $responseData = json_encode(array('success' => 'File uploaded successfully','name' => $fileNameNew));
                        }
                        else {
                            $strErrorDesc = 'File size too big';
                            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                        }
                    }   
                } else {
                    $strErrorDesc = 'You cannot upload files of this type!';
                    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
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