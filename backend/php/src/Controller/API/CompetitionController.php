<?php
class CompetitionController extends BaseController
{
    // Funktion zu verarbeitung des eingesendeten projekts  
    public function competitionAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen 
                $newproject = new ModelProject();
                $usermodel = new ModelTeilnehmende();
                $competitionmodel = new ModelCompetition();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // User erstellen
                $answerUser = $usermodel->createUser($data['user']);
                if ($answerUser == 0) {
                    $responseData = 2; //Falls ein User bereits exsistiert mit der Email
                } else {
                    // id von neuem User auf Variable speichern
                    $data['project']['userid'] = $usermodel->id;
                    // Projekt erstellen 
                    $answerProject = $newproject->createProject($data['project']);
                    // Bilder in seperate Variable platzieren
                    $picturebase64 = $data['pics'];
                    // Abfrage Betriebssystem
                    if (PHP_OS == "Linux") {
                        // BilderPfad auf dem Server
                        $generalpath =getenv('F_PATH') . '/project';
                        // ProjectId auf Variable setzen
                        $number = $newproject->getId();
                        // Dem Pfad die Nummer anbinden
                        $newPath = $generalpath . strval($number);
                        // erstellen des Projektordners
                        mkdir($newPath, 0777, true);
                        // neuen Pfad mit GUID
                        $newPath = $newPath . '/' . $this->GUID();
                        // GUID Ordner erstellen (Sicherheitsvorkehrung)
                        mkdir($newPath, 0777, true);
                        // Bilder Speichern und auf DB Pfad speichern
                        $this->saveImage($picturebase64, $newPath, $newproject->getId());
                    } elseif (PHP_OS == "Windows") {
                        // BilderPfad auf dem Server
                        $generalpath = "C:\Wettbewerb\project";
                        // ProjectId auf Variable setzen
                        $number = $newproject->getId();
                        // Dem Pfad die Nummer anbinden
                        $newPath = $generalpath . strval($number);
                        // erstellen des Projektordners
                        mkdir($newPath, 0777, false);
                        // neuen Pfad mit GUID
                        $newPath = $newPath . '/' . $this->GUID();
                        // GUID Ordner erstellen (Sicherheitsvorkehrung)
                        mkdir($newPath, 0777, false);
                        // Bilder Speichern und auf DB Pfad speichern
                        $this->saveImage($picturebase64, $newPath, $newproject->getId());
                    }
                    // Information Wettbewerb holen
                    $ans = $competitionmodel->getCompetition();
                    // Mail versenden (param: Mail, Token, PW, Name, Surname, Wettbewerbende)
                    if (getenv('SEND_MAIL_CUSTOMER_BOOLEAN')) {
                        $this->sendmail($data['user']['email'], $usermodel->getToken(), $usermodel->getPw(), $data['user']['name'], $data['user']['surname'], $ans['wettbewerbende']);
                    } else {
						error_log('Usermail:'.$data['user']['email']);
                        error_log('Token: ' . $usermodel->getToken());
	                    error_log('PW: ' . $usermodel->getPw());
                    }
                    // Überprüfung ob erstellung von Projekt und User erfolgreich waren
                    if ($answerProject == 1 & $answerUser == 1) {
                        $responseData = true;
                    } else {
                        $responseData = false;
                    }
                }
            } else {
                // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
            }
        } catch (Error $e) {
            // Fehlermeldung, falls ein serverseitiger Fehler entstanden ist
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }
        // Falls kein Fehler enthalten ist wird die Antwort verpackt und versendet
        if (!$strErrorDesc && ($requestMethod == 'POST')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));

            // Falls ein Fehler enthalten ist wird dieser verpackt und versendet
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
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Aufruf benötigter Klassen 
                $competitionmodel = new ModelCompetition();
                // Wettbewerbinformationen von der DB holen
                $ans = $competitionmodel->getCompetition();
                // als Antwort Daten in Json formatieren 
                $responseData = json_encode($ans);

                // abfrage ob es eine POST_Methode ist
            } elseif (strtoupper($requestMethod) == 'POST') {
                // Überprüfung gültiger Session
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);

                    // Überprüfung erlaubter Rollen
                } else if (!$this->userCheck('admin')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $competition = new ModelCompetition();
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    // Wettbewerbsdaten Updaten
                    $competition->updateData($data);
                    // Reaktion zurücksenden
                    $responseData = true;
                }
            } else {
                // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
            }
        } catch (Error $e) {
            // Fehlermeldung, falls ein serverseitiger Fehler entstanden ist
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }
        // Falls kein Fehler enthalten ist wird die Antwort verpackt und versendet
        if (!$strErrorDesc && ($requestMethod == 'GET' || $requestMethod == 'POST')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));

            // Falls ein Fehler enthalten ist wird dieser verpackt und versendet
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}