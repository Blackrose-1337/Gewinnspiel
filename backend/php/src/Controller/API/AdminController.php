<?php

class AdminController extends BaseController
{
	//API Funktion um das alte Passwort zu reseten und ein neues Passwort für den User zu generieren
	public function pwresetAction()
	{
		// Variablen setzen
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		// QueryParams entgegennehmen
		$arrQueryStringParams = $this->getQueryStringParams();
		try {
			// Überprüfung gültiger Session
			if (!$this->sessionCheck()) {
				$strErrorDesc = "Nicht akzeptierte Session";
				$strErrorHeader = $this->fehler(405);

				// Überprüfung erlaubter Rollen
			} elseif (!$this->userCheck('admin')) {
				$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
				$strErrorHeader = $this->fehler(401);
			} else {
				// abfrage ob es eine GET_Methode ist
				if (strtoupper($requestMethod) == 'GET') {
					// Aufruf benötigter Klassen
					$usermodel = new ModelTeilnehmende();
					$pwmodel = new ModelPw();
					$saltmodel = new ModelSalt();
					// Userinformationen holen
					$user = $usermodel->getUser($arrQueryStringParams['userId']);
					// neuen salt generieren
					$saltmodel->resetSaltbyID($user['saltId']);
					// neuen salt holen
					$salt = $saltmodel->getSaltbyID($user['saltId']);
					// passwort erstellen hash genieren mit salt und neues passwort erhalten
					$pw = $pwmodel->resetHashbyId($salt, $user['pwId']);
					// Mail mit neuem PW an den User versenden;
					$this->sendMailWithNewPW($user['email'], $pw, $user['name'], $user['surname']);
					$responseData = true;
				} else {
					// Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
					$strErrorDesc = 'Method not supported';
					$strErrorHeader = $this->fehler(422);
				}
			}
		} catch (Error $e) {
			// Fehlermeldung, falls ein serverseitiger Fehler entstanden ist
			$strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
			$strErrorHeader = $this->fehler(500);
		}
		// Falls kein Fehler enthalten ist wird die Antwort verpackt und versendet
		if (!$strErrorDesc && ($requestMethod == 'GET')) {
			$this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));

			// Falls ein Fehler enthalten ist wird dieser verpackt und versendet
		} else {
			$this->sendOutput(
				json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}

	public function setpwAction()
	{
		// Variablen setzen
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		try {
			// Überprüfung gültiger Session
			if (!$this->sessionCheck()) {
				$strErrorDesc = "Nicht akzeptierte Session";
				$strErrorHeader = $this->fehler(405);

				// Überprüfung erlaubter Rollen
			} elseif (!$this->userCheck('admin')) {
				$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
				$strErrorHeader = $this->fehler(401);
			} else {
				// abfrage ob es eine POST_Methode ist
				if (strtoupper($requestMethod) == 'POST') {
					// Aufruf benötigter Klassen
					$usermodel = new ModelTeilnehmende();
					$pwmodel = new ModelPw();
					$saltmodel = new ModelSalt();
					// Post Daten holen
					$data = json_decode(file_get_contents('php://input'), true);
					// Userinformationen holen
					$user = $usermodel->getUserwithMail($data['email']);
					// neuen salt generieren
					$saltmodel->resetSaltbyID($user['saltId']);
					// neuen salt holen
					$salt = $saltmodel->getSaltbyID($user['saltId']);
					// neuen hash generieren mit neuem passwort und salt
					$pwCheck = $pwmodel->setNewHashbyId($salt, $user['pwId'], $data['password']);
					$message = new stdClass();
					if ($pwCheck) {
						$message->answer = true;
						$message->message = 'Passwort erfolgreich gesetzt';
						$message->type = 'positive';
					} else {
						$message->answer = false;
						$message->message = 'Passwort konnte nicht neu gesetzt werden';
						$message->type = 'negative';
					}
					$responseData = json_encode($message);

				} else {
					// Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
					$strErrorDesc = 'Method not supported';
					$strErrorHeader = $this->fehler(422);
				}
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

	//API Funktion um Änderungen zu speichern die der Admin bei einem User macht
	public function saveAction()
	{
		// Variablen setzen
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		try {
			// Überprüfung gültiger Session
			if (!$this->sessionCheck()) {
				$strErrorDesc = "Nicht akzeptierte Session";
				$strErrorHeader = $this->fehler(405);

				// Überprüfung erlaubter Rollen
			} elseif (!$this->userCheck('admin', 'teilnehmende')) {
				$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
				$strErrorHeader = $this->fehler(401);
			} else {
				// abfrage ob es eine POST_Methode ist
				if (strtoupper($requestMethod) == 'POST') {
					// Aufruf benötigter Klassen
					$usermodel = new ModelTeilnehmende();
					// Post Daten holen
					$data = json_decode(file_get_contents('php://input'), true);

					// Überprüfung ob der Admin die Aktion ausführt
					if ($_SESSION['user_role'] == 'admin') {
						// Falls id 0 hinterlegt ist wird ein neuer User erstellt
						if ($data['id'] == 0) {
							$usermodel->createUser($data);
							$responseData = 1;
							// Andernfalls wird mit der Id der User gesucht und die Daten überschrieben
						} else {
							// Änderung der Userdaten
							error_log('User: ' . $responseData = $usermodel->changeUser($data));
						}

						// Falls die Rolle eines Users aktiv ist, wird eine Überprüfung der Session(user_id) mit der übergebenen Id durchgeführt (damit kein User dazu in der Lage ist Daten eines anderen zu ändern)
					} else if ($_SESSION['user_role'] == 'teilnehmende' && $_SESSION['user_id'] == $data['id']) {
						// Änderung der Userdaten
						error_log('User: ' . $responseData = $usermodel->changeUser($data));
					} else {
						// Fehlermeldung, falls keine entsprechenden Berechtigungen vorhanden sind
						$strErrorDesc = 'Nicht autorisiert';
						$strErrorHeader = $this->fehler(401);
					}

				} else {
					// Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
					$strErrorDesc = 'Method not supported';
					$strErrorHeader = $this->fehler(422);
				}
			}
		} catch (Error $e) {
			// Fehlermeldung, falls ein serverseitiger Fehler entstanden ist
			$strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
			$strErrorHeader = $this->fehler(500);
		}

		// Falls kein Fehler enthalten ist wird die Antwort verpackt und versendet
		if (!$strErrorDesc) {
			$this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));

			// Falls ein Fehler enthalten ist wird dieser verpackt und versendet
		} else {
			$this->sendOutput(
				json_encode(array('error' => $strErrorDesc)),
				array('Content-Type: application/json', $strErrorHeader)
			);
		}
	}

	//API Funktion um ein Projekt inclusive User vollständig zu Löschen
	public function removeAction()
	{
		// Variablen setzen
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		try {
			// Überprüfung gültiger Session
			if (!$this->sessionCheck()) {
				$strErrorDesc = "Nicht akzeptierte Session";
				$strErrorHeader = $this->fehler(405);

				// Überprüfung erlaubter Rollen
			} elseif (!$this->userCheck('admin')) {
				$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
				$strErrorHeader = $this->fehler(401);

				// Abfrage ob es eine POST_Methode ist
			} elseif (strtoupper($requestMethod) == 'POST') {
				// Aufruf benötigter Klassen
				$projectmodel = new ModelProject();
				$usermodel = new ModelTeilnehmende();
				$bewertungmodel = new ModelBewertung();
				$saltmodel = new ModelSalt();
				$pwmodel = new ModelPw();
				// Post Daten holen
				$data = json_decode(file_get_contents('php://input'), true);

				// project_id holen
				$project = $projectmodel->getProject($data['userId']);
				// falls ein Projekt vorhanden ist
				if ($project['id']) {
					// Überprüfung ob eine Bewertung vorhanden ist
					if ($bewertungmodel->checkBewertung($project['id'])) {
						$message = new stdClass();
						$message->answer = false;
						$message->message = 'Bewertung vorhanden - User kann nicht gelöscht werden';
						$message->type = 'negative';
						$responseData = json_encode($message);
					}
				}
				// Überprüfung der mitgegeben 'userId'
				if ($data['userId'] !== 0) {
					if ($usermodel->getUserRole($data['userId'])[0]['role'] == 'teilnehmende') {
						// Löschen des Projekts über UserID
						$projectmodel->deleteProjectWithUserId($data);
					}
					//PW- und SaltID holen
					$ans = $usermodel->getPwSaltId($data['userId']);

					// Löschen des Users (übergabe voller User)
					$checkuserdelete = $usermodel->deleteUser($data);
					// Salt und Pw Löschen
					$checksaltdelete = $saltmodel->deleteSaltDB($ans[0]['saltId']);
					$checkpwdelete = $pwmodel->deleteHashDB($ans[0]['pwId']);
					$message = new stdClass();
					if ($checkuserdelete && $checksaltdelete && $checkpwdelete) {
						$message->answer = true;
						$message->message = 'User erfolgreich gelöscht';
						$message->type = 'positive';
					} else {
						$message->answer = false;
						$message->message = 'User konnte nicht gelöscht werden';
						$message->type = 'negative';
					}
					$responseData = json_encode($message);
				} else {
					// Antwort, wenn 'userId' nicht hinterlegt ist oder auf 0 gesetzt
					$responseData = false;
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
		if (!$strErrorDesc) {
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