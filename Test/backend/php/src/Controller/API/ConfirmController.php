<?php
class ConfirmController extends BaseController
{
    public function confirmAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelTeilnehmende();
                // Userdaten nehmen Mocking
                if (isset($arrQueryStringParams['token'])) {
                    $answer = $usermodel->tokencheck($arrQueryStringParams['token']);
                    $responseData = json_encode($answer);
                } else {
                    $strErrorDesc = 'Falsche Ressource';
                    $strErrorHeader = $this->fehler(420);
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
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }
    }
}
?>