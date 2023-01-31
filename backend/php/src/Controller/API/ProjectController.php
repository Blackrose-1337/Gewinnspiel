<?php
class ProjectController extends BaseController
{
    // Funktion um ein Projekt abzurufen
    public function takeAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'GET') {
            try {
                // Aufruf benötigter Klassen 
                $projectmodel = new ModelProject();
                $bildermodel = new ModelBilder();

                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin', 'teilnehmende')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else if ($_SESSION['user_role'] == 'teilnehmende') {
                    error_log('---------------hier--------------------');

                    $answer = $projectmodel->getProject($_SESSION['user_id']);
                    $imgs = $bildermodel->getPictureByProId($answer['id']);
                    $base64 = [];
                    foreach ($imgs as $img) {
                        $pic = $this->getImage($img['path']);
                        array_push($base64, $pic);
                    }
                    $answer['pics'] = $base64;
                    $responseData = json_encode($answer);
                } else if ($_SESSION['user_role'] != 'teilnehmende') {
                    if (isset($arrQueryStringParams['userId'])) {
                        // $responseData = json_encode($projectmodel->getProject($arrQueryStringParams['userId']));
                        error_log('-----------------------------------');
                        $answer = json_encode($projectmodel->getProject($_SESSION['user_id']));
                        error_log($answer);
                        $responseData = 0;
                    }
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
    public function takeAllAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'GET') {
            try {
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                } else if (!$this->userCheck('admin', 'jury')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $projectmodel = new ModelProject();
                    // Projekt laden Mocking und in ein Json-Format umwandeln
                    $responseData = json_encode($projectmodel->getAllProject());
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
    public function updateAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        // abfrage ob es eine POST_Methode ist
        if (strtoupper($requestMethod) == 'POST') {
            try {
                if (!$this->sessionCheck()) {
                    $strErrorDesc = "Nicht akzeptierte Session";
                    $strErrorHeader = $this->fehler(405);
                }
                if (!$this->userCheck('admin', 'teilnehmende')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $projectmodel = new ModelProject();
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    if ($data['id'] !== 0) {
                        $responseData = $projectmodel->updateProject($data);
                    } else {
                        $responseData = false;
                    }
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