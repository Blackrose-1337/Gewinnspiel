<?php
class AuthController extends BaseController
{
    // Funktion um ein Projekt abzurufen
    public function LoginAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $requestHeaders = apache_request_headers();
        $Authorization = trim($requestHeaders['Authorization']);

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'POST') {
            try {

                if (isset($_SESSION['user_id'])) {
                    $strErrorDesc = 'Sie sind bereits angemeldet';
                    $strErrorHeader = $this->fehler(406);
                } else {
                    // Aufruf benötigter Klassen 
                    $usermodel = new ModelTeilnehmende;
                    $saltmodel = new ModelSalt;
                    $pwmodel = new ModelPw;

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
                            print_r("Passwort ist falsch");

                        } else {

                            $str = $this->rndtoken();
                            $str2 = $this->rndtoken();
                            $answer = [
                                [
                                    "success" => 1,
                                    "token" => [$str, $str2],
                                    "time" => "12h",
                                ]
                            ];
                            $token = $str2 . $user['email'] . $str;
                            // var_dump($test[0]);
                            $usermodel->createUserSession($user['id'], $user['email'], $user['name'], $user['role'], $token);
                            $responseData = json_encode($answer[0]);
                        }
                    }


                    //$responseData = true;
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
    public function SessionAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $requestHeaders = apache_request_headers();
        $Authorization = trim($requestHeaders['Authorization']);

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $usermodel = new ModelTeilnehmende;

                $data = json_decode(file_get_contents('php://input'), true);
                $tk1 = isset($data['email']) ? $data['tk1'] : "";
                $tk2 = isset($data['password']) ? $data['tk2'] : "";
                if (!isset($_SESSION['user_id'])) {
                    try {
                        // print_r($_SESSION['user_id']);
                        if ($tk1 == '' || $tk2 == '') {
                            $tk1 == $this->rndtoken();
                            $tk2 == $this->rndtoken();
                        }
                        $token = $tk2 . $tk1;
                        $usermodel->createUserSession(0, '', 'guest', 'guest', $token);
                        $answer = [
                            [
                                "success" => 0,
                                "role" => $_SESSION['user_role'],
                                "time" => "12h",
                            ]
                        ];
                        $responseData = json_encode($answer);
                    } catch (Error $e) {
                        $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                        $strErrorHeader = $this->fehler(500);
                    }
                } else {

                    $tk = $tk2 . $_SESSION['user_email'] . $tk1;
                    if ($_SESSION['token'] == $tk) {
                        $answer = [
                            [
                                "success" => 1,
                                "role" => $_SESSION['user_role'],
                                "time" => "12h",
                            ]
                        ];
                        $responseData = json_encode($answer);
                    } else {
                        $strErrorDesc = 'Session is not valid';
                        $strErrorHeader = $this->fehler(405);
                    }
                }

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = $this->fehler(500);
            }
        } elseif (strtoupper($requestMethod) == 'GET') {

        } elseif (strtoupper($requestMethod) == 'OPTIONS') {
            $responseData = true;
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