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
        try {
            if (strtoupper($requestMethod) == 'POST') {

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

    public function bewertungAction()
    {
        $strErrorDesc = '';
        // Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            if (strtoupper($requestMethod) == 'GET') {
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin', 'jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    $bewertungmodel = new ModelBewertung();
                    $answer = $bewertungmodel->getBewertung($arrQueryStringParams);
                    $responseData = json_encode($answer);
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
    public function imagesAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Aufruf benötigter Klassen 
                $bildermodel = new ModelBilder();
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin', 'teilnehmende', 'jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else if ($_SESSION['user_role'] == 'jury' || $_SESSION['user_role'] == 'admin') {
                    $imgs = $bildermodel->getPictureByProId($arrQueryStringParams['id']);
                    $base64 = [];
                    foreach ($imgs as $img) {
                        $pic = $this->getImage($img['path']);
                        array_push($base64, $pic);
                    }
                    $answer['pics'] = $base64;
                    $responseData = json_encode($answer);
                } else if ($_SESSION['user_role'] != 'teilnehmende') {
                    if (isset($arrQueryStringParams['userId'])) {
                        $responseData = 0;
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

    public function analysisAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {

                // Aufruf benötigter Klassen 
                $bildermodel = new ModelBilder();

                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else if ($_SESSION['user_role'] == 'admin') {
                    $bewertungmodel = new ModelBewertung();
                    $projectmodel = new ModelProject();
                    $usermodel = new ModelTeilnehmende();
                    $bewertungen = $bewertungmodel->getAuswertung();
                    $arr = [];
                    foreach ($bewertungen as $bewertung) {
                        $ans = $projectmodel->getUserIdWithId(json_encode($bewertung['projectId']));
                        $bewertung['userId'] = $ans[0]['userId'];
                        array_push($arr, $bewertung);
                    }
                    $responseData = [];
                    foreach ($arr as $a) {
                        $ans = $usermodel->getUserinfo($a);
                        array_push($responseData, $ans);
                    }
                    $oldkey = 'projectId';
                    $newkey = 'id';
                    $responseData = str_replace('"' . $oldkey . '":', '"' . $newkey . '":', json_encode($responseData));
                } else if ($_SESSION['user_role'] != 'admin') {
                    if (isset($arrQueryStringParams['userId'])) {
                        $responseData = 0;
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
}

?>