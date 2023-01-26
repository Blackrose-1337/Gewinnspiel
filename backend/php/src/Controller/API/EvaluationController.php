<?php

//noch in arbeit

class EvaluationController extends BaseController
{
    public function getKriterienAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (!$this->sessionCheck()) {
            $strErrorDesc = "Nicht akzeptierte Session";
            $strErrorHeader = $this->fehler(405);
        } else if (!$this->userCheck('admin', 'jury')) {
            $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
            $strErrorHeader = $this->fehler(401);
        } else {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                try {
                    // Aufruf benötigter Klassen 
                    $bewertungmodel = new ModelBewertung();

                    // Kriteriendaten nehmen Mocking
                    $arr = $bewertungmodel->getKriterien();
                    // Daten in json unformen
                    $responseData = json_encode($arr);

                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                    $strErrorHeader = $this->fehler(500);
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
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
    }

    public function createBewertungAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'POST') {

            try {
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin', 'jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    $bewertungmodel = new ModelBewertung();
                    $data = json_decode(file_get_contents('php://input'), true);
                    foreach ($data as $k => $v) {
                        $bewertungmodel->createOrUpdateBewertung($v);
                    }
                    $responseData = 1;
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = $this->fehler(422);
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

    public function bewertungAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin', 'jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    $bewertungmodel = new ModelBewertung();
                    error_log(json_encode($arrQueryStringParams));
                    $answer = $bewertungmodel->getBewertung($arrQueryStringParams);
                    $responseData = json_encode($answer);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = $this->fehler(422);
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
}

?>