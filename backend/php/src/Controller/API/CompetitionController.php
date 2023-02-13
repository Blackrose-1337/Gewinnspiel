<?php
class CompetitionController extends BaseController
{
    // Funktion zu verarbeitung des eingesendeten projekts  
    public function competitionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen 
                $newproject = new ModelProject();
                $usermodel = new ModelTeilnehmende();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // User erstellen
                $answerUser = $usermodel->createUser($data['user']);
                error_log(json_encode($answerUser));
                if ($answerUser == 0) {
                    $responseData = 2;
                } else {
                    $data['project']['userid'] = $usermodel->id;
                    // Projekt erstellen 
                    $answerProject = $newproject->createProject($data['project']);
                    $picturebase64 = $data['pics'];
                    if (PHP_OS == "Linux") {
                        $generalpath = "./project";
                        $number = $this->countfolder("./images");
                        $newPath = $generalpath . strval($number);
                        mkdir($newPath, 0777, false);
                        $newPath = $newPath . '/' . $this->GUID();
                        mkdir($newPath, 0777, false);
                        $this->saveImage($picturebase64, $newPath, $newproject->getId());
                    } elseif (PHP_OS == "Windows") {
                        mkdir("C:\Wettbewerb");
                        $generalpath = "C:\Wettbewerb\project";
                        $number = $this->countfolder("C:\Wettbewerb");
                        $newPath = $generalpath . strval($number);
                        mkdir($newPath, 0777, false);
                        $newPath = $newPath . '/' . $this->GUID();
                        mkdir($newPath, 0777, false);
                        $this->saveImage($picturebase64, $newPath, $newproject->getId());
                    }
                    $this->sendmail($data['user']['email'], $usermodel->getToken(), $usermodel->getPw());
                    // Reaktion zurücksenden
                    if ($answerProject == 1& $answerUser == 1) {
                        $responseData = true;
                    } else {
                        $responseData = false;
                    }
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
            }
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
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
        try {
            if (strtoupper($requestMethod) == 'GET') {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelCompetition();
                $arr = $usermodel->getCompetition();
                $responseData = json_encode($arr);
            } elseif (strtoupper($requestMethod) == 'POST') {
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
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
            }
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
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