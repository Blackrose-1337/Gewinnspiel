<?php
class UserController extends BaseController
{
    public function listAction()
    {   
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET'){
            try 
            {
                $usermodel = new ModelTeilnehmende();
                $arr = $usermodel->getFakeDataUser();
                $responseData = json_encode($arr);
            } 
            catch (Error $e) 
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }         
        } elseif (strtoupper($requestMethod) == 'POST') {
            try
            {
                $usermodel = new ModelTeilnehmende();
                $usermodel->fakewriteData($_POST);
                print_r($_POST);
            }
            catch (Error $e) 
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if(!$strErrorDesc && ($requestMethod=='GET'))
        {
            $this->sendOutput($responseData,array('Content-Type: application/json', 'HTTP/1.1 200 Blackrose'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
            array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}