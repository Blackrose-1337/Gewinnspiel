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
            // abfrage, ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen 
                $newProject = new ModelProject();
                $userModel = new ModelTeilnehmende();
                $competitionModel = new ModelCompetition();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // User erstellen
                $answerUser = $userModel->createUser($data['user']);
                if ($answerUser == 0) {
                    $responseData = 2; //Falls etwas schief ging
                } else {
                    // id von neuem User auf Variable speichern
                    $data['project']['userid'] = $userModel->id;
	                // Bilder in seperate Variable platzieren
	                $pictureBase64 = $data['pics'];
                    // Projekt erstellen 
                    $answerProject = $newProject->createProject($data['project'], count($pictureBase64));
                    // Abfrage Betriebssystem
                    if (PHP_OS == "Linux") {
                        // BilderPfad auf dem Server
                        $generalPath =getenv('F_PATH') . '/project';
                        // ProjectId auf Variable setzen
                        $number = $newProject->getId();
                        // Dem Pfad die Nummer anbinden
                        $newPath = $generalPath . strval($number);
                        // erstellen des Projektordners
	                    mkdir($newPath, 0775, true);
                        // neuen Pfad mit GUID
                        $newPath = $newPath . '/' . $this->GUID();
                        // GUID Ordner erstellen (Sicherheitsvorkehrung)
	                    mkdir($newPath, 0775, true);
                        // Bilder Speichern und auf DB Pfad speichern
                        $this->saveImage($pictureBase64, $newPath, $newProject->getId());
                    } elseif (PHP_OS == "Windows") {
                        // BilderPfad auf dem Server
                        $generalPath = "C:\Wettbewerb\project";
                        // ProjectId auf Variable setzen
                        $number = $newProject->getId();
                        // Dem Pfad die Nummer anbinden
                        $newPath = $generalPath . strval($number);
                        // erstellen des Projektordners
                        mkdir($newPath, 0777, false);
                        // neuen Pfad mit GUID
                        $newPath = $newPath . '/' . $this->GUID();
                        // GUID Ordner erstellen (Sicherheitsvorkehrung)
                        mkdir($newPath, 0777, false);
                        // Bilder Speichern und auf DB Pfad speichern
                        $this->saveImage($pictureBase64, $newPath, $newProject->getId());
                    }
                    // Information Wettbewerb holen
                    $ans = $competitionModel->getCompetition();
                    // Mail versenden (param: Mail, Token, PW, Name, Surname, Wettbewerbende)
	                $anzahlProjekte = $newProject->checkProjectOnPerson($userModel->id);
                    if ($competitionModel->isMailAllowed() && $anzahlProjekte == 1) {
                       $this->sendmail($data['user']['email'], $userModel->getToken(), $userModel->getPw(), $data['user']['name'], $data['user']['surname'], $ans['wettbewerbende']);
                    } else {
	                    error_log('Usermail:' . $data['user']['email']);
	                    if ($anzahlProjekte == 1) {
		                    error_log('Token: ' . $userModel->getToken());
		                    error_log('PW: ' . $userModel->getPw());
	                    }
                    }
                    // Überprüfung ob erstellung von Projekt und User erfolgreich waren
                    if ($answerProject == 1 & $answerUser != 0) {
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
                $competitionModel = new ModelCompetition();
                // Wettbewerbinformationen von der DB holen
                $ans = $competitionModel->getCompetition();
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

	public function logoAction()
	{
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		try {

			// abfrage ob es eine GET_Methode ist
			if (strtoupper($requestMethod) == 'GET') {

				$path = "./inc/logo.png";
				// als Antwort Daten in Json formatieren
				$responseData = json_encode($path);

				// abfrage ob es eine POST_Methode ist
			} else if (strtoupper($requestMethod) == 'POST') {
				if (!$this->sessionCheck()) {
					$strErrorDesc = "Nicht akzeptierte Session";
					$strErrorHeader = $this->fehler(405);
				} else if (!$this->userCheck('admin')) {
					$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
					$strErrorHeader = $this->fehler(401);
				} else {
					// Post Daten holen
					$data = json_decode(file_get_contents('php://input'), true);
					// Wettbewerbsdaten Updaten
					$this->saveLogo($data);
					// Reaktion zurücksenden
					$responseData = true;
				}
			}
			else {
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
		} else {
			// Falls ein Fehler enthalten ist wird dieser verpackt und versendet
			$this->sendOutput(
				json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}
}