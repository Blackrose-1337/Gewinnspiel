<?php
class AdminController extends BaseController
{
    // Funktion um das alte Passwort zu reseten und ein neues Passwort für den User zu generieren 
    public function pwresetAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // QueryParams entgegennehmen
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            }
            if (!$this->userCheck('admin')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            } else {
                if (strtoupper($requestMethod) == 'GET') {
                    // Aufruf benötigter Klassen 
                    $usermodel = new ModelTeilnehmende();
                    $pwmodel = new ModelPw();
                    $saltmodel = new ModelSalt();
                    // benötigte id's zu salt und PW abrufen 
                    $ids = $usermodel->getUser($arrQueryStringParams['userId']);
                    // neuen salt generieren 
                    $saltmodel->resetSaltbyID($ids['saltId']);
                    $salt = $saltmodel->getSaltbyID($ids['saltId']);
                    // passwort erstellen hash genieren mit salt und passwort zurückgeben
                    $pw = $pwmodel->resetHashbyId($salt, $ids['pwId']);
                    $responseData = true;
                } else {
                    $strErrorDesc = 'Method not supported';
                    $strErrorHeader = $this->fehler(422);
                }
            }
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }
        if (!$strErrorDesc && ($requestMethod == 'GET')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    // Funktion um Änderungen zu speichern die der Admin bei einem User macht
    public function saveAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            }
            if (!$this->userCheck('admin', 'teilnehmende')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            } else {
                // abfrage ob es eine POST_Methode ist
                if (strtoupper($requestMethod) == 'POST') {
                    // Aufruf benötigter Klassen 
                    $usermodel = new ModelTeilnehmende();
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    // Check ob ein User oder Admin Action ausführen will    
                    if ($_SESSION['user_role'] == 'admin') {
                        // Falls id 0 hinterlegt ist wird ein neuer User erstellt
                        if ($data['id'] == 0) {
                            $usermodel->createUser($data);
                            // Andernfalls wird mit der Id der User gesucht und die Daten überschrieben
                        } else {
                            $usermodel->changeUser($data);
                            $responseData = 1;
                        }
                    } else if ($_SESSION['user_role'] == 'teilnehmende') {
                        $usermodel->changeUser($data);
                        $responseData = 1;
                    } else {
                        $strErrorDesc = 'Nicht autorisiert';
                        $strErrorHeader = $this->fehler(401);
                    }

                } else {
                    $strErrorDesc = 'Method not supported';
                    $strErrorHeader = $this->fehler(422);
                }
            }
        } catch (Error $e) {
            echo "Error";
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }

        if (!$strErrorDesc) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function removeAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                }
                if (!$this->userCheck('admin')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $projectmodel = new ModelProject();
                    $usermodel = new ModelTeilnehmende();
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    if ($data['id'] !== 0) {
                        $projectmodel->deleteProjectWithUserId($data);
                        $responseData = $usermodel->deleteUser($data);
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
        if (!$strErrorDesc) {
            $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

// private function parseData($string)
// {
//     $data = null;
//     try {
//         $data = json_decode($string);
//     } catch (Exception $e) {
//         $data = false;
//     }

//     return $data;
// }

}