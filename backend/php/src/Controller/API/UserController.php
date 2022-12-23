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
                // Userdaten holen
                $arr = $usermodel->getDataUser();
                // Daten in json unformen
                $responseData = json_encode($arr);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } elseif (strtoupper($requestMethod) == 'POST') {
            try {
                $usermodel = new ModelTeilnehmende();
                $data = json_decode(file_get_contents('php://input'), true);
                $responseData = $usermodel->fakewriteData($data);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = $this->fehler(422);
        }
        if (!$strErrorDesc && ($requestMethod == 'GET')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
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
                $user = $usermodel->getUser($arrQueryStringParams['userId']);
                // Daten in json unformen
                $responseData = json_encode($user);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = $this->fehler(422);
        }
        if (!$strErrorDesc && ($requestMethod == 'GET')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}