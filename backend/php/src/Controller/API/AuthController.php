<?php
//error_reporting(1);

class AuthController extends BaseController
{
    // LoginFunktion Session setzen
    public function LoginAction()
    {

        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'POST') {

            // Aufruf benötigter Klassen 
            $usermodel = new ModelTeilnehmende;
            $saltmodel = new ModelSalt;
            $pwmodel = new ModelPw;

            try {
                error_log(session_status());

                error_log("");
                error_log("----------------Session Cookie---------------- ");
                if (isset($_COOKIE['PHPSESSID'])) {
                    error_log("Sent Coookie : " . $_COOKIE['PHPSESSID']);
                    error_log("Session ID :   " . session_id());
                } else {
                    error_log("There is no PHPSESSID-Coookie exists");
                }
                error_log("");
                error_log("----------------Session Information-----------------");
                if ($_SESSION) {
                    foreach ($_SESSION as $key => $val) {
                        error_log($key . " : " . $val);
                    }
                } else {
                    error_log("There is no SESSION exists");
                    if (!$_SESSION) {
                        session_regenerate_id();
                        error_log("------------------------------");
                        error_log("Reset Session ID");
                    }
                }
                error_log("");

                if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
                    $strErrorDesc = $_SESSION['role'];
                    $strErrorHeader = $this->fehler(406);
                } elseif (!isset($_COOKIE['PHPSESSID']) || !isset($_SESSION['id'])) {
                    error_log("TESTTETSTETSTETST---------------------------------");
                    $data = json_decode(file_get_contents('php://input'), true);
                    $email = isset($data['email']) ? $data['email'] : "";
                    $passwort = isset($data['password']) ? $data['password'] : "";
                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]+$/", $email)) {
                        $strErrorDesc = 'Ungültige E-Mail';
                        $strErrorHeader = $this->fehler(420);
                    } elseif (strlen($passwort) < 12 || !preg_match("/^[a-zA-Z0-9\?\!\+\@]/", $passwort)) {
                        $strErrorDesc = 'Das Passwort ist kürzer als 12 Zeichen oder enthält nicht erlaubte Zeichen';
                        $strErrorHeader = $this->fehler(420);
                    } else {
                        //search User by email
                        $user = $usermodel->getUserwithMail($email);
                        //search Salt by saltId from User
                        $salt = $saltmodel->getSaltbyID($user['saltId']);
                        //controll Hash with password and salt
                        $controll = $pwmodel->controllHash($passwort, $salt, $user['pwId']);
                        if (!$controll) {
                            $strErrorDesc = "Passwort ist falsch";
                            $strErrorHeader = $this->fehler(401);
                        } else {
                            $this->createUserSession($user['id'], $user['email'], $user['name'], $user['role']);

                            $answer = [
                                "success" => 1,
                                "role" => $user['role'],
                            ];
                            $responseData = json_encode($answer);
                        }
                    }
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
            // } else if (strtoupper($requestMethod) == 'OPTIONS') {
            //     $responseData = true;
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
    public function checkAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'GET') {
            try {

                if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
                    $answer = [
                        "success" => 1,
                        "role" => $_SESSION['user_role'],
                    ];

                    $responseData = json_encode($answer);

                } else {
                    $answer = [
                        "success" => 0,
                        "role" => '',
                    ];
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
    public function logoutAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            error_log(session_status());
            error_log("----------------");
            if (session_status() == 2) {
                error_log('');
                error_log($_COOKIE['PHPSESSID']);
                error_log($_SESSION['id']);
                error_log('');
                if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
                    session_unset();
                    session_destroy();
                    error_log(session_status());
                    $answer = [
                        "success" => 0,
                        "role" => '',
                    ];
                    $responseData = json_encode($answer);
                } else {
                    $strErrorDesc = 'Something went wrong! Please contact support.';
                    $strErrorHeader = $this->fehler(500);
                    $answer = [
                        "success" => 1,
                    ];
                    $responseData = json_encode($answer);
                }
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