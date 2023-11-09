<?php
class ProjectController extends BaseController
{
    //API Funktion um ein Projekt abzurufen
    public function takeAction()
    {
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
            } // Überprüfung erlaubter Rollen
            else if (!$this->userCheck('admin', 'teilnehmende')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            } // abfrage ob es eine GET_Methode ist
            else if (strtoupper($requestMethod) == 'GET') {
                // Aufruf benötigter Klassen 
                $projectmodel = new ModelProject();
                $bildermodel = new ModelBilder();
                // Abruf des eigenen Projektes als 'teilnehmende' Rolle
                if ($_SESSION['user_role'] == 'teilnehmende') {
					if ($projectmodel->checkProject($_SESSION['user_id'])){
						// Projekt wird geholt mit 'user_id' der Session
						$answer = $projectmodel->getProject($_SESSION['user_id']);
					} else {
						$answer = null;
					}
                    // Abruf eines pezifischen Projektes als Admin
                } else if ($_SESSION['user_role'] == 'admin') {
					if ($projectmodel->checkProject($arrQueryStringParams['userId'])) {
						// Projekt wird geholt anhand mitgebener User-Id
						$answer = $projectmodel->getProject($arrQueryStringParams['userId']);
					} else {
						$answer = null;
					}
                }
				if (isset($answer['id'])) {
					// Bilder werden geholt mittels Projekt-ID
					$imgs = $bildermodel->getPictureByProId($answer['id']);
					// Array Vorbereitung
					$base64 = [];
					// verpacken der Bilder und push in den Array
					foreach ($imgs as $img) {
						$pic = $this->getImage($img['path']);
						array_push($base64, $pic);
					}
					// Array noch verpacken
					$answer['pics'] = $base64;
				} else {
					$answer['pics'] = null;
				}
	            // Antwort zu Json formatieren
	            $responseData = json_encode($answer);
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

    // API Funktion alle Projekte abrufen (nur für Admin und Jury)
    public function takeAllAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // Überprüfung gültiger Session
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);

                // Überprüfung erlaubter Rollen
            } else if (!$this->userCheck('admin', 'jury')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            }
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Aufruf benötigter Klassen 
                $projectmodel = new ModelProject();
                // Abfrage aller Projekte direkt zu Json formatiert
                $responseData = json_encode($projectmodel->getAllProject());
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

    // API Funktion Projekt updaten
    public function updateAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // Überprüfung gültiger Session
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            } // Überprüfung erlaubter Rollen
            else if (!$this->userCheck('admin', 'teilnehmende')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            }
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen 
                $projectmodel = new ModelProject();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
				error_log(print_r($data, true));
                // Überprüfung ob die ID nicht 0 ist
                if ($data['id'] !== 0) {
                    // update Projekt
                 $responseData = $projectmodel->updateProject($data);
                } else {
                    $responseData = $projectmodel->createProject($data);
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

    // API Funktion Projekt löschen (auch der User wird gelöscht)
   /* public function deleteAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // Überprüfung gültiger Session
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            } // Überprüfung erlaubter Rollen
            else if (!$this->userCheck('admin')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            }
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen 
                $projectmodel = new ModelProject();
				$bewertungmodel = new ModelBewertung();
				$usermodel = new ModelTeilnehmende();
	            $saltmodel = new ModelSalt();
	            $pwmodel = new ModelPw();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
	            $message = new stdClass();
	            if ($data['id'] !== 0) {
		            // User id holen aus projekt
		            $userID = $projectmodel->getUserIdWithId($data['id']);
		            // User holen
		            $user = $usermodel->getUser($userID[0]['userId']);
					$projects = $projectmodel->getAnyProject($userID[0]['userId']);
					$count = count($projects);
					$liste = "Folgende Projekte konnten nicht gelöscht werden: ";
					foreach ($projects as $project) {
						if (!$bewertungmodel->checkBewertung($project['id'])) {
							if (!$projectmodel->deleteProject($project)) {
								$liste .= $project['title'] . ', ';
							} else {
								$count--;
							}
						}
						if ($count == 0) {
							// Löschen des Users (übergabe voller User)
							$checkuserdelete = $usermodel->deleteUser($userID[0]);
							// Salt und Pw Löschen
							$checksaltdelete = $saltmodel->deleteSaltDB($user['saltId']);
							$checkpwdelete = $pwmodel->deleteHashDB($user['pwId']);
							if ($checkuserdelete && $checksaltdelete && $checkpwdelete) {
								$message->answer = true;
								$message->message = 'User & Projekte erfolgreich gelöscht';
								$message->type = 'positive';
							} else {
								$message->answer = false;
								$message->message = 'User konnte nicht gelöscht werden';
								$message->type = 'negative';
							}
						} else {
							$message->answer = false;
							$message->message = 'User & '.$liste;
							$message->type = 'negative';
						}
					}
	            }  else {
	            $message->answer = false;
	            $message->message = 'User & Projekt konnten nicht gelöscht werden';
	            $message->type = 'negative';
                }
	            $responseData = json_encode($message);
            } else {
                // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
            }
        } catch (Error $e) {
            // Fehlermeldung, falls ein serverseitiger Fehler entstanden ists
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
    }*/

	public function deleteProjectAction()
	{
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		try {
			// Überprüfung gültiger Session
			if (!$this->sessionCheck()) {
				$strErrorDesc = "Nicht akzeptierte Session";
				$strErrorHeader = $this->fehler(405);
			} // Überprüfung erlaubter Rollen
			else if (!$this->userCheck('admin', 'teilnehmende')) {
				$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
				$strErrorHeader = $this->fehler(401);
			}
			// abfrage ob es eine POST_Methode ist
			if (strtoupper($requestMethod) == 'POST') {
				// Aufruf benötigter Klassen
				$competitionmodel = new ModelCompetition();
				$projectmodel = new ModelProject();
				$bewertungmodel = new ModelBewertung();

				if($competitionmodel->isDeleteAllowed()) {
					// Post Daten holen
					$data = json_decode(file_get_contents('php://input'), true);
					$message = new stdClass();
					if ($bewertungmodel->checkBewertung($data['id'])) {
						$message->answer = false;
						$message->message = 'Bewertung vorhanden - Projekt kann nicht gelöscht werden';
						$message->type = 'negative';
						$responseData = json_encode($message);
					} else {
						// Überprüfung ob die ID nicht 0 ist
						if ($data['id'] !== 0) {
							// löschen des Projektes
							if ($projectmodel->deleteProject($data)) {
								$message->answer = true;
								$message->message = 'Projekt erfolgreich gelöscht';
								$message->type = 'positive';
							} else {
								$message->answer = false;
								$message->message = 'Projekt konnte nicht gelöscht werden';
								$message->type = 'negative';
							}
						} else {
							$message->answer = false;
							$message->message = 'Projekt konnten nicht gelöscht werden';
							$message->type = 'negative';
						}
					}
				} else {
					$message = new stdClass();
					$message->answer = false;
					$message->message = 'Projekt kann nicht gelöscht werden';
					$message->type = 'negative';
				}
				$responseData = json_encode($message);
			} else {
				// Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
				$strErrorDesc = 'Method not supported';
				$strErrorHeader = $this->fehler(422);
			}
		} catch (Error $e) {
			// Fehlermeldung, falls ein serverseitiger Fehler entstanden ists
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

    // API Funktion Bild löschen auf DB und Bild in trash Ordner verschieben
    public function deletePictureAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // Überprüfung gültiger Session
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            } // Überprüfung erlaubter Rollen
            else if (!$this->userCheck('admin', 'teilnehmende')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            }
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen 
                $picmodel = new ModelBilder();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                if ($data['projectId'] !== 0) {
					// überprüfen Anzahl Bilder
	                $count = $picmodel->getPictureCount($data['projectId']);
					error_log("Anzahl Bilder: ");
					error_log($count[0]["COUNT(*)"]);
					if ($count[0]["COUNT(*)"] > 1) {
						// auftrennung des Strings
						$newdata = explode('/', $data['imgPath']);
						// neuen Pfad definieren
						$newpath = './' . $newdata[3] . '/' . $newdata[4] . '/' . $newdata[5] . '/' . $newdata[6];
						// löschen aus der DB mittels Pfad und Projekt-ID
						$picmodel->DeletePath($newpath, $data['projectId']);
						// Bild in den Ordner 'trash' verschieben, falls es jemand nicht wollte noch zu retten ist Administrativ
						rename($newpath, getenv('F_PATH').'/trash/' . $newdata[4] . '-' . $newdata[6] . '-' . count(scandir(getenv('F_PATH').'/trash')));
						$responseData = true;
					} else {
						$message = new stdClass();
						$message->answer = false;
						$message->message = 'Projekt muss mindestens ein Bild besitzen';
						$message->type = 'negative';
						$responseData = json_encode($message);
					}
                } else {
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

    // API Funktion Bilder hinzufügen
    public function addPictureAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $imagePath = getenv('F_PATH');
        try {
            // Überprüfung gültiger Session
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            } // Überprüfung erlaubter Rollen
            else if (!$this->userCheck('admin', 'teilnehmende')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            }
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen
                $projectmodel = new ModelProject();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // User-ID holen mittel Projekt-ID
                $id = $projectmodel->getUserIdWithId($data[0]['projectId']);
				$number = $projectmodel->getPictureIncrement($data[0]['projectId']);
                /* Überprüfung ob die aktive Rolle ein Admin ist oder ob die ID übereinstimmt mit der 'user_id'
               der Session, damit 'teilnehmende' nur ihrem Projekt Bilder hinzufügen können */
                if ($id[0]['userId'] == $_SESSION['user_id'] || $_SESSION['user_role'] == 'admin') {
                    if ($data[0]['projectId'] !== 0) {
                        // Pfad zum Elternordner bestimmen
                        $parent_dir = $imagePath . '/project' . $data[0]['projectId'] . '/*';
                        // holt alle Datein und Ordner in dem Verzeichnis
                        $newpath = glob($parent_dir);
                        // Überprüfung ob in dem Ordner schon Dateien enthalten sind
                        if (count(scandir($newpath[0])) > 12 ){
							// Fehlermeldung, falls der Ordner schon 10 Bilder enthält
							$strErrorDesc = "Zu viele Bilder in diesem Projekt";
							$strErrorHeader = $this->fehler(422);
						} else {
	                        // Ziffer um 1 erhöhen
	                        $number =  $number + 1;
                            // Bildspeichern Funktion aufrufen
                            $this->saveImage($data, $newpath[0], $data[0]['projectId'], $number);
                        }
                        $responseData = true;
                    } else {
                        $responseData = false;
                    }
                } else {
                    /* Fehlermeldung, falls nicht der Benutzer mit den entspechenden Rechten diese Aktion durführen will oder
                    dies bei einem fremden Projekt versucht*/
                    $strErrorDesc = "Nicht berechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
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
	// API Funktion aller freigegebenen Projekte abrufen
	public function takeprojectsAction()
	{
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		try {
			// Überprüfung gültiger Session
			if (!$this->sessionCheck()) {
				$strErrorDesc = "Nicht akzeptierte Session";
				$strErrorHeader = $this->fehler(405);

				// Überprüfung erlaubter Rollen
			} else if (!$this->userCheck('jury', 'admin')) {
				$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
				$strErrorHeader = $this->fehler(401);
			}
			// abfrage ob es eine GET_Methode ist
			if (strtoupper($requestMethod) == 'GET') {
				// Aufruf benötigter Klassen
				$projectmodel = new ModelProject();
				// Abfrage aller Projekte direkt zu Json formatiert
				$responseData = json_encode($projectmodel->getAllProjectwithfinish());
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

    public function takeAllProjectsUserAction()
    {
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
		    } // Überprüfung erlaubter Rollen
		    else if (!$this->userCheck('admin', 'teilnehmende')) {
			    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
			    $strErrorHeader = $this->fehler(401);
		    } // abfrage ob es eine GET_Methode ist
		    else if (strtoupper($requestMethod) == 'GET') {
			    // Aufruf benötigter Klassen
			    $projectmodel = new ModelProject();
			    $bildermodel = new ModelBilder();

			    // Abruf des eigenen Projektes als 'teilnehmende' Rolle
			    if ($_SESSION['user_role'] == 'teilnehmende') {
				    if ($projectmodel->checkProject($_SESSION['user_id'])){
					    // Projekt wird geholt mit 'user_id' der Session
					    $answer = $projectmodel->getProjects($_SESSION['user_id']);
				    } else {
					    $answer = null;
				    }
				    // Abruf eines pezifischen Projektes als Admin
			    } else if ($_SESSION['user_role'] == 'admin') {
				    if ($projectmodel->checkProject($arrQueryStringParams['userId'])) {
					    // Projekt wird geholt anhand mitgebener User-Id
					    $answer = $projectmodel->getProject($arrQueryStringParams['userId']);
				    } else {
					    $answer = null;
				    }
			    }

			   /* foreach ($answer as &$value) {
				    if (isset($value['id'])) {

					    // Bilder werden geholt mittels Projekt-ID
					    $imgs = $bildermodel->getPictureByProId($value['id']);
					    // Array Vorbereitung
					    $base64 = [];
					    // verpacken der Bilder und push in den Array
					    foreach ($imgs as $img) {
						    $pic = $this->getImage($img['path']);
						    array_push($base64, $pic);
					    }
					    // Array noch verpacken
					    $value['pics'] = $base64;
					    error_log(print_r($value, true));
					    error_log(count($value['pics']));
					    // Antwort zu Json formatieren
				    } else {
					    $value['pics'] = null;
				    }
				    unset($value);
			    }*/

			    $responseData = json_encode($answer);
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

	public function newProjectAction()
	{
		$strErrorDesc = '';
		// Kommunikations-Methode entnehmen
		$requestMethod = $_SERVER["REQUEST_METHOD"];
		try {
			// abfrage, ob es eine POST_Methode ist
			if(!$this->sessionCheck()) {
				$strErrorDesc = "Nicht akzeptierte Session";
				$strErrorHeader = $this->fehler(405);
			} else if (!$this->userCheck('teilnehmende')) {
				$strErrorDesc = "Unberechtigt diese Aktion auszuführen";
				$strErrorHeader = $this->fehler(401);
			} else if (strtoupper($requestMethod) == 'POST') {
				// Aufruf benötigter Klassen
				$newProject = new ModelProject();
				$userModel = new ModelTeilnehmende();
				// Post Daten holen
				$data = json_decode(file_get_contents('php://input'), true);
				// User erstellen
				$answerUser = $userModel->getUser($_SESSION['user_id']);
				if ($answerUser == 0) {
					$responseData = 2; //Falls etwas schief ging
				} else {
					// id von neuem User auf Variable speichern
					$data['project']['userid'] = $_SESSION['user_id'];
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

	// API Funktion Projekt Freigeben
    public function approvalAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // Überprüfung gültiger Session
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);

                // Überprüfung erlaubter Rollen
            } else if (!$this->userCheck('admin', 'jury')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            }
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen
                $projectmodel = new ModelProject();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // Aufruf der Funktion um das Project Frei zu geben
                $responseData = $projectmodel->approvalProject($data);
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