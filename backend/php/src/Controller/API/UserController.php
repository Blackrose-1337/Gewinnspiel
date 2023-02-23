<?php
class UserController extends BaseController
{
    // Funktion zum Abruf aller UserDaten bei einer GET-Anfrage
    public function listAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            }
            if (!$this->userCheck('admin')) {
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
                    // entfernen von Daten die nicht gebraucht werden
                    foreach ($arr as $val) {
                        unset($val['saltId']);
                        unset($val['pwId']);
                        array_push($newarr, $val);
                    }
                    // Daten in json unformen
                    $responseData = json_encode($newarr);
                } elseif (strtoupper($requestMethod) == 'POST') {
                    $usermodel = new ModelTeilnehmende();
                    $data = json_decode(file_get_contents('php://input'), true);
                    $responseData = $usermodel->fakewriteData($data);
                } else {
                    $strErrorDesc = 'Method not supported';
                    $strErrorHeader = $this->fehler(422);
                }
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
    public function getUserAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            if (!$this->sessionCheck()) {
                $strErrorDesc = "Nicht akzeptierte Session";
                $strErrorHeader = $this->fehler(405);
            } else if (!$this->userCheck('admin', 'teilnehmende')) {
                $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                $strErrorHeader = $this->fehler(401);
            } else {
                // abfrage ob es eine GET_Methode ist
                if (strtoupper($requestMethod) == 'GET') {
                    // Aufruf benötigter Klassen 
                    $usermodel = new ModelTeilnehmende();
                    // Userdaten nehmen Mocking
                    if (isset($arrQueryStringParams['userId'])) {
                        $user = $usermodel->getUser($arrQueryStringParams['userId']);
                    } else {
                        $user = $usermodel->getUser($_SESSION['user_id']);
                    }
                    // Daten in json unformen
                    unset($user['saltId']);
                    unset($user['pwId']);
                    $responseData = json_encode($user);
                } else {
                    $strErrorDesc = 'Method not supported';
                    $strErrorHeader = $this->fehler(422);
                }
            }
            if (!$strErrorDesc) {
                $this->sendOutput($responseData, array('Content-Type: application/json', $this->success(200)));
            } else {
                $this->sendOutput(
                    json_encode(array('error' => $strErrorDesc)),
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
            $strErrorHeader = $this->fehler(500);
        }
    }
}