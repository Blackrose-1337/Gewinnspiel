<?php
class UserController extends BaseController
{
    // Funktion zum Abruf aller UserDaten
    public function listAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // Überprüfung gültiger Session
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            }

            // Überprüfung erlaubter Rollen
            else if (!$this->userCheck('admin')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            } else {
                // abfrage ob es eine GET_Methode ist
                if (strtoupper($requestMethod) == 'GET') {
                    // Aufruf benötigter Klassen 
                    $usermodel = new ModelTeilnehmende();
                    // Userdaten holen
                    $arr = $usermodel->getDataUser();
                    $newarr = [];
                    // entfernen von Daten die nicht gebraucht werden und in neuen Array pushen
                    foreach ($arr as $val) {
                        unset($val['saltId']);
                        unset($val['pwId']);
                        array_push($newarr, $val);
                    }
                    // Daten in json unformen
                    $responseData = json_encode($newarr);
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
    public function getUserAction()
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

                // Überprüfung erlaubter Rollen
            } else if (!$this->userCheck('admin', 'teilnehmende')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            } else {
                // abfrage ob es eine GET_Methode ist
                if (strtoupper($requestMethod) == 'GET') {
                    // Aufruf benötigter Klassen 
                    $usermodel = new ModelTeilnehmende();
                    // falls eine User-ID mitgeben wurde wird diese abgerufen ansonsten diese des aktiven Users
                    if (isset($arrQueryStringParams['userId']) && $_SESSION['user_role'] == 'admin') {
                        $user = $usermodel->getUser($arrQueryStringParams['userId']);
                    } else {
                        $user = $usermodel->getUser($_SESSION['user_id']);
                    }
                    // unötige informationen entfernen
                    unset($user['saltId']);
                    unset($user['pwId']);
                    // Daten in json unformen
                    $responseData = json_encode($user);
                } else {
                    // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                    $strErrorDesc = 'Method not supported';
                    $strErrorHeader = $this->fehler(422);
                }
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
        } catch (Error $e) {
            // Fehlermeldung, falls ein serverseitiger Fehler entstanden ist
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }
    }
}