<?php
class ConfirmController extends BaseController
{
    public function confirmAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // QueryParams entgegennehmen
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelTeilnehmende();
                // Kontrolle ob Token in der URL enthalten ist
                if (isset($arrQueryStringParams['token'])) {
                    // Token wird überprüft
                    $answer = $usermodel->tokencheck($arrQueryStringParams['token']);
                    // Antwort 
                    $responseData = json_encode($answer);
                } else {
                    // Fehlermeldung, falls kein Token korrekt übergeben wurde
                    $strErrorDesc = 'Falsche Ressource';
                    $strErrorHeader = $this->fehler(420);
                }
            } else {
                // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
            }
            // Falls kein Fehler enthalten ist wird die Antwort verpackt und versendet
            if (!$strErrorDesc && ($requestMethod == 'GET')) {
                $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
            } else {

                // Falls ein Fehler enthalten ist wird dieser verpackt und versendet
                $this->sendOutput(
                    json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        } catch (Error $e) {
            // Fehlermeldung, falls ein serverseitiger Fehler entstanden ist
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }
    }
}
?>