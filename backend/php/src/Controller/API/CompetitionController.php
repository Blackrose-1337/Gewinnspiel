<?php
class CompetitionController extends BaseController
{
    // Funktion zu verarbeitung des eingesendeten projekts  
    public function competitionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        print_r($requestMethod);
        if (strtoupper($requestMethod) == 'GET') {
            try {
                // Aufruf benötigter Klassen 

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } elseif (strtoupper($requestMethod) == 'POST') {
            try {
                // Aufruf benötigter Klassen 
                $newproject = new ModelProject();
                $usermodel = new ModelTeilnehmende();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // User erstellen
                $answerUser = $usermodel->createUser($data['user']);
                $data['project']['userid'] = $usermodel->id;
                // Projekt erstellen 
                $answerProject = $newproject->createProject($data['project']);
                if (PHP_OS == "Linux") {
                    $generalpath = "../../data/project";
                    $newPath = $generalpath;
                    mkdir($newPath, 0777, false);
                }
                // Reaktion zurücksenden
                if ($answerProject == 1& $answerUser == 1) {
                    $responseData = true;
                } else {
                    $responseData = false;
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = $this->fehler(422);
        }
        if (!$strErrorDesc && ($requestMethod == 'GET' || $requestMethod == 'POST')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    public function competitionDetailsAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        // $check = new Authcheck;
        //$answer = $check->authcheck();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelCompetition();
                $arr = $usermodel->getCompetition();
                $responseData = json_encode($arr);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } elseif (strtoupper($requestMethod) == 'POST') {
            try {
                // Aufruf benötigter Klassen 
                $competition = new ModelCompetition();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // update Competition
                $competition->updateData($data);
                // Reaktion zurücksenden
                $responseData = true;
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } elseif (strtoupper($requestMethod) == 'OPTIONS') {
            $responseData = true;
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = $this->fehler(422);
        }
        if (!$strErrorDesc && ($requestMethod == 'GET' || $requestMethod == 'POST')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

}