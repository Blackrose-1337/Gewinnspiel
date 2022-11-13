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
                $ids = $usermodel->getFakeUser($arrQueryStringParams['userId']);
                // neuen salt generieren 
                $salt = $saltmodel->resetSaltbyID($ids['saltId']);
                // passwort erstellen hash genieren mit salt und passwort zurückgeben
                $pw = $pwmodel->resetHashbyId($salt, $ids['pwId']);

                $responseData = true;

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc && ($requestMethod == 'GET')) {
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 Blackrose'));
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
                    $usermodel->fakeCreateUser($data);

                    // Andernfalls wird mit der Id der User gesucht und die Daten überschrieben
                } else {
                    $usermodel->fakeChangeUser($data);
                }

            } catch (Error $e) {
                echo "Error";
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
    }

}