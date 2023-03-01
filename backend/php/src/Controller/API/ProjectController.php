<?php
class ProjectController extends BaseController
{
    // Funktion um ein Projekt abzurufen
    public function takeAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
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
                    $answer = $projectmodel->getProject($_SESSION['user_id']);
                    $imgs = $bildermodel->getPictureByProId($answer['id']);
                    $base64 = [];
                    foreach ($imgs as $img) {
                        $pic = $this->getImage($img['path']);
                        array_push($base64, $pic);
                    }
                    $answer['pics'] = $base64;
                    $responseData = json_encode($answer);
                } else if ($_SESSION['user_role'] == 'admin') {
                    $answer = $projectmodel->getProject($arrQueryStringParams['userId']);
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
                        $answer = json_encode($projectmodel->getProject($_SESSION['user_id']));
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
    public function takeAllAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
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
    public function updateAction()
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
                        error_log('test');
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

    public function deleteAction()
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
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    if ($data['id'] !== 0) {
                        $responseData = $projectmodel->deleteProject($data);
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

    public function deletePictureAction()
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
                if (!$this->userCheck('admin', 'teilnehmende')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $picmodel = new ModelBilder();
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    if ($data['projectId'] !== 0) {
                        $newdata = explode('/', $data['imgpath']);
                        $newpath = './' . $newdata[3] . '/' . $newdata[4] . '/' . $newdata[5] . '/' . $newdata[6];
                        $picmodel->DeletePath($newpath, $data['projectId']);
                        unlink($newpath);
                        $responseData = true;
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
    public function addPictureAction()
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
                if (!$this->userCheck('admin', 'teilnehmende')) {
                    $strErrorDesc = "Unberechtigt diese Aktion auszuführen";
                    $strErrorHeader = $this->fehler(401);
                } else {
                    // Aufruf benötigter Klassen 
                    $picmodel = new ModelBilder();
                    $projectmodel = new ModelProject();
                    // Post Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);

                    error_log('-------------------------------------');
                    $data[0]['id'] = $projectmodel->getUserIdWithId($data[0]['projectId']);


                    if ($data[0]['id'] == $_SESSION['user_id'] || $_SESSION['user_role'] == 'admin') {
                        if ($data[0]['projectId'] !== 0) {
                            $parent_dir = './images/project' . $data[0]['projectId'] . '/*';
                            $newpath = glob($parent_dir);
                            $maxTsFile = 0;
                            $nFileName = "";
                            if (count(scandir($newpath[0])) > 2) {
                                $test = glob($newpath[0] . '/*.*');
                                foreach ($test as $fileName) {
                                    $ts = filemtime($fileName);
                                    if ($ts > $maxTsFile) {
                                        $maxTsFile = $ts;
                                        $nFileName = $fileName;
                                    }
                                }
                                $ele = explode('/', $nFileName);
                                $ele = explode('e', $ele[4]);
                                $ele = explode('.', $ele[1]);
                                error_log(json_encode($ele));
                                $number = (int) $ele[0] + 1;

                                $this->saveImage($data, $newpath[0], $data[0]['projectId'], $number);
                            } else {
                                $this->saveImage($data, $newpath[0], $data[0]['projectId']);
                            }
                            $responseData = true;
                        } else {
                            $responseData = false;
                        }
                    } else {
                        $strErrorDesc = "Nicht berechtigt diese Aktion auszuführen";
                        $strErrorHeader = $this->fehler(401);
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