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

        if (strtoupper($requestMethod) == 'GET') {
            try {
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

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = $this->fehler(422);
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
        $arrQueryStringParams = $this->getQueryStringParams();

        // abfrage ob es eine POST_Methode ist
        if (strtoupper($requestMethod) == 'POST') {
            try {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelTeilnehmende();
                // Post Daten holen
                $data = json_decode(file_get_contents('php://input'), true);
                // Falls id 0 hinterlegt ist wird ein neuer User erstellt
                if ($data['id'] == 0) {
                    $usermodel->createUser($data);

                    // Andernfalls wird mit der Id der User gesucht und die Daten überschrieben
                } else {
                    $usermodel->changeUser($data);
                    $responseData = true;
                }

            } catch (Error $e) {
                echo "Error";
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        }
    }

}