<?php
class CompetitionController extends BaseController
{
    // Funktion zu verarbeitung des eingesendeten projekts  
    public function competitionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelCompetition();
                $arr = $usermodel->getfakecompetition();
                $responseData = json_encode($arr);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } elseif (strtoupper($requestMethod) == 'POST') {
            try {
                // Aufruf benötigter Klassen 
                $newproject = new ModelProject();
                $usermodel = new ModelTeilnehmende();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // User erstellung Mocking
                $data['user'] = $usermodel->fakewriteData($data['user']);
                // Projekt erstellen Mocking
                $data['project'] = $newproject->fakeWriteData($data['project']);
                // Reaktion zurücksenden
                $responseData = json_encode($data);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc && ($requestMethod == 'GET' || $requestMethod == 'POST')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 Blackrose'));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

}