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
                    // Projekt wird geholt mit 'user_id' der Session
                    $answer = $projectmodel->getProject($_SESSION['user_id']);

                    // Abruf eines pezifischen Projektes als Admin
                } else if ($_SESSION['user_role'] == 'admin') {
                    // Projekt wird geholt anhand mitgebener User-Id
                    $answer = $projectmodel->getProject($arrQueryStringParams['userId']);
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
                    // Antwort zu Json formatieren
                    $responseData = json_encode($answer);
                } else {
                    $answer['pics'] = null;
                    $responseData = json_encode($answer);
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

    // API Funktion alle Projekte abrufen
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
                // Überprüfung ob die ID nicht 0 ist
                if ($data['id'] !== 0) {
                    // update Projekt
                 error_log('Project: ' . $responseData = $projectmodel->updateProject($data));
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

    // API Funktion Projekt löschen
    public function deleteAction()
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
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // Überprüfung ob die ID nicht 0 ist
                if ($data['id'] !== 0) {
                    // löschen des Projektes
                    $responseData = $projectmodel->deleteProject($data);
                } else {
                    $responseData = false;
                }
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
                /* Überprüfung ob die aktive Rolle ein Admin ist oder ob die ID übereinstimmt mit der 'user_id'
               der Session, damit 'teilnehmende' nur ihrem Projekt Bilder hinzufügen können */
                if ($id[0]['userId'] == $_SESSION['user_id'] || $_SESSION['user_role'] == 'admin') {
                    if ($data[0]['projectId'] !== 0) {
                        // Pfad zum Elternordner bestimmen
                        $parent_dir = $imagePath . '/project' . $data[0]['projectId'] . '/*';
                        // holt alle Datein und Ordner in dem Verzeichnis
                        $newpath = glob($parent_dir);
                        // Variablen vordefinieren
                        $maxTsFile = 0;
                        $nFileName = "";

                        // Überprüfung ob in dem Ordner schon Dateien enthalten sind
                        if (count(scandir($newpath[0])) > 2) {
                            $test = glob($newpath[0] . '/*.*');
                            // Loop um den Pfad der neusten Datei zu erhalten
                            foreach ($test as $fileName) {
                                $ts = filemtime($fileName);
                                if ($ts > $maxTsFile) {
                                    $maxTsFile = $ts;
                                    $nFileName = $fileName;
                                }
                            }
                            // Trennung des Pfadestrings um die Ziffer zu erhalten
                            $ele = explode('/', $nFileName);
                            $ele = explode('e', $ele[4]);
                            $ele = explode('.', $ele[1]);
                            // Ziffer um 1 erhöhen
                            $number = (int)$ele[0] + 1;
                            // Bildspeichern mit neuer Nummerierung
                            $this->saveImage($data, $newpath[0], $data[0]['projectId'], $number);
                        } else {
                            // Bildspeichern ohne zusätzliche die Nummerierung zu beeinflussen
                            $this->saveImage($data, $newpath[0], $data[0]['projectId']);
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
            } else if (!$this->userCheck('admin', 'jury')) {
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