<?php
class CompetitionController extends BaseController
{
    // Funktion zu verarbeitung des eingesendeten projekts  
    public function competitionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
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
                $picturebase64 = $data['pics'];
                error_log(json_encode($picturebase64));
                if (PHP_OS == "Linux") {
                    $generalpath = "../data/project";
                    $number = $this->countfolder("../../data");
                    $newPath = $generalpath . strval($number);
                    mkdir($newPath, 0777, false);
                    $this->saveImage($picturebase64, $newPath, $newproject->getId());
                } elseif (PHP_OS == "Windows") {
                    mkdir("C:\Wettbewerb");
                    $generalpath = "C:\Wettbewerb\project";
                    $number = $this->countfolder("C:\Wettbewerb");
                    $newPath = $generalpath . strval($number);
                    mkdir($newPath, 0777, false);
                    $this->saveImage($picturebase64, $newPath, $newproject->getId());
                }
                $this->sendmail($data['user']['email'], 'test', $usermodel->getPw());
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
        if (!$strErrorDesc && ($requestMethod == 'POST')) {
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
        error_log('-----------hier------');
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
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $competition = new ModelCompetition();
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    // update Competition
                    $competition->updateData($data);
                    // Reaktion zurücksenden
                    $responseData = true;
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

}