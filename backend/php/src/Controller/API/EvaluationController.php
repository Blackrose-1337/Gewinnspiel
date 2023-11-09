<?php

//noch in arbeit

class EvaluationController extends BaseController
{
    // API Funktion Kriterienraster Abrufen
    public function getKriterienAction()
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
            } else {
                // abfrage ob es eine GET_Methode ist
                if (strtoupper($requestMethod) == 'GET') {

                    // Aufruf benötigter Klassen 
                    $bewertungmodel = new ModelBewertung();
                    // Kriterien von DB holen
                    $arr = $bewertungmodel->getKriterien();
                    // Daten in json unformen
                    $responseData = json_encode($arr);

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


    // API Funktion Bewertungen Speichern
    public function createBewertungAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {

                // Überprüfung gültiger Session
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);

                    // Überprüfung erlaubter Rollen
                } else if (!$this->userCheck('jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    $bewertungmodel = new ModelBewertung();
                    // POST-Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    // jede Bewertung im loop abarbeiten
                    foreach ($data as $k => $v) {
                        // einzelne Bewertung übergeben
                        $bewertungmodel->createOrUpdateBewertung($v);
                    }
                    $responseData = 1;
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

    // API Funktion Bewertungen holen
    public function bewertungAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // QueryParams entgegennehmen
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Überprüfung gültiger Session
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);

                    // Überprüfung erlaubter Rollen
                } else if (!$this->userCheck('admin', 'jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $bewertungmodel = new ModelBewertung();
                    $projectmodel = new ModelProject();
                    // Abfrage Bewertungen mittels Projekt-Id und User-Id(Session)
                    $answer = $bewertungmodel->getBewertung($arrQueryStringParams);
                    if (count($answer) == 0){
                        $answer = $projectmodel->projectCheck($arrQueryStringParams);
                        if ($answer == 0) {
                            $message = [ 'exists' => $answer, 'meldung' => 'Es besteht kein Projekt mit dieser ID'];
                            $responseData = json_encode($message);
                        } else {
							if ($_SESSION['user_role'] != 'admin')
							{
								$message = [ 'exists' => $answer, 'meldung' => 'Es besteht noch keine Bewertung für das Projekt'];
								$responseData = json_encode($message);
							} else {
								$responseData = 1;
							}
                        }
                    } else {
                        // Antwort als json verpacken
                        $responseData = json_encode($answer);
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

    // API Funktion Bilder-URL holen
    public function imagesAction()
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
                $projectmodel = new ModelProject();
                $bildermodel = new ModelBilder();
                // Überprüfung gültiger Session
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                    // Überprüfung erlaubter Rollen
                } else if (!$this->userCheck('admin', 'teilnehmende', 'jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);

                    // Überprüfung, ob die Rolle Jury, Admin ist oder die angefragten Bilder auch zu dem Teilnehmenden wirklich gehören
                } else if ($_SESSION['user_role'] == 'jury' || $_SESSION['user_role'] == 'admin' || $_SESSION['user_id'] == $projectmodel->getUserIdWithId($arrQueryStringParams['id'])[0]['userId']) {
                    // alle Bilderpfade von DB holen
                    $imgs = $bildermodel->getPictureByProId($arrQueryStringParams['id']);
                    // Array vorbereiten
                    $base64 = [];
                    // jeden Bildpfad sauber verpacken und in den Array pushen
                    foreach ($imgs as $img) {
                        $pic = $this->getImage($img['path']);
                        array_push($base64, $pic);
                    }
                    // Array noch verpacken
                    $answer['pics'] = $base64;
                    // Antwort zu Json formatieren
                    $responseData = json_encode($answer);

                    // Überprüfen der Rolle
                } else if ($_SESSION['user_role'] == 'teilnehmende') {
                    // Fehlermeldung, falls zwar ein Teilnehmer eine Anfrage sendet. Diese aber nicht sein Projekt ist
                    $strErrorDesc = 'Falsche Ressource';
                    $strErrorHeader = $this->fehler(420);
                } else {
                    $responseData = 0;
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

    // API Funktion Auswertung holen
    public function analysisAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Überprüfung gültiger Session
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);

                    // Überprüfung erlaubter Rollen
                }
				else if ($this->userCheck('admin'))
				{
                    // Aufruf benötigter Klassen
                    $bewertungModel = new ModelBewertung();
                    $projectModel = new ModelProject();
                    $userModel = new ModelTeilnehmende();

                    // Alle Auswertungen von DB holen (Summe Bewertungen pro Projekt)
                    $auswertungen = $bewertungModel->getAuswertung();
                    // Array bereitstellen
                    $arr = [];
                    // jede Auswertung mit User-Id verpacken und in Array pushen
                    foreach ($auswertungen as $auswertung) {
                        $ans = $projectModel->getUserIdWithId(json_encode($auswertung['projectId']));
                        $auswertung['userId'] = $ans[0]['userId'];
                        array_push($arr, $auswertung);
                    }
                    // Array bereitstellen
                    $responseData = [];
                    // Für jede Auswertung noch Userinformationen hinzufügen
                    foreach ($arr as $a) {
                        $ans = $userModel->getUserinfo($a);
                        array_push($responseData, $ans);
                    }
                    // Vorbereitung für Frontend Bezeichnung
                    $oldKey = 'projectId';
                    $newKey = 'id';
                    $responseData = str_replace('"' . $oldKey . '":', '"' . $newKey . '":', json_encode($responseData));
                } else {
	                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
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

    public function bewertungsCheckAction()
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
            } else if (!$this->userCheck('admin')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            }
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                    // Aufruf benötigter Klassen
                    $bewertungModel = new ModelBewertung();
                    $responseData = json_encode($bewertungModel->getMissingProject());
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

?>