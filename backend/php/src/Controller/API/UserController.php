<?php
class UserController extends BaseController
{
    // Funktion zum Abruf aller UserDaten bei einer GET-Anfrage
    public function listAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'GET') {
            try {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelTeilnehmende();
                // Userdaten nehmen Mocking
                $arr = $usermodel->getFakeDataUser();
                // Daten in json unformen
                $responseData = json_encode($arr);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } elseif (strtoupper($requestMethod) == 'POST') {
            try {
                $usermodel = new ModelTeilnehmende();


                $data = json_decode(file_get_contents('php://input'), true);
                $responseData = $usermodel->fakewriteData($data);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc && ($requestMethod == 'GET')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 Blackrose'));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    public function getUserAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'GET') {
            try {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelTeilnehmende();
                // Userdaten nehmen Mocking
                $user = $usermodel->getFakeUser($arrQueryStringParams['userId']);
                // Daten in json unformen
                $responseData = json_encode($user);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc && ($requestMethod == 'GET')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 Blackrose'));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}