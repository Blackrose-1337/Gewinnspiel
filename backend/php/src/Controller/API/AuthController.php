<?php
class AuthController extends BaseController
{
    // LoginFunktion Session setzen
    public function LoginAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Aufruf benötigter Klassen 
                $usermodel = new ModelTeilnehmende;
                $saltmodel = new ModelSalt;
                $pwmodel = new ModelPw;
                // Loging
                error_log("----------------Session Cookie---------------- ");
                if (isset($_COOKIE['PHPSESSID'])) {
                    error_log("Sent Coookie : " . $_COOKIE['PHPSESSID']);
                    error_log("Session ID :   " . session_id());
                } else {
                    error_log("There is no PHPSESSID-Coookie exists");
                }
                error_log("----------------Session Information-----------------");
                if ($_SESSION) {
                    foreach ($_SESSION as $key => $val) {
                        error_log($key . " : " . $val);
                    }
                } else {
                    error_log("There is no SESSION exists");
                    if (!$_SESSION) {
                        session_regenerate_id();
                        error_log("Reset Session ID");
                    }
                }
                // Überprüfung ob Session schon existiert und übereinstimmt
                if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
                    // Fehlermeldung, falls eine Session schon bereits existiert
                    $strErrorDesc = $_SESSION['role'];
                    $strErrorHeader = $this->fehler(406);

                    // Falls Cookie oder Session nicht existieren
                } elseif (!isset($_COOKIE['PHPSESSID']) || !isset($_SESSION['id'])) {
                    // POST-Daten holen
                    $data = json_decode(file_get_contents('php://input'), true);
                    // Überprüfung ob Mail-Adresse und Passwort gesetzt ist
                    $email = isset($data['email']) ? $data['email'] : "";
                    $passwort = isset($data['password']) ? $data['password'] : "";
                    // Validierung Mail-Adresse
                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]+$/", $email)) {
                        // Fehlermeldung, falls die Validierung der Mail-Adresse fehlgeschlagen ist
                        $strErrorDesc = 'Ungültige E-Mail';
                        $strErrorHeader = $this->fehler(420);

                        // Validierung Passwort
                    } elseif (strlen($passwort) < 12 || !preg_match("/^[a-zA-Z0-9\?\!\+\@]/", $passwort)) {
                        // Fehlermeldung, falls die Validierung des Passwortes fehlgeschlagen ist
                        $strErrorDesc = 'Das Passwort ist kürzer als 12 Zeichen oder enthält nicht erlaubte Zeichen';
                        $strErrorHeader = $this->fehler(420);
                    } else {
                        // User von DB holen anhand der Mail-Adresse
                        $user = $usermodel->getUserwithMail($email);
                        // Salt von DB holen anhand der Salt-Id
                        $salt = $saltmodel->getSaltbyID($user['saltId']);
                        // Abgleich des Hash anhand des Passwortes und Salt
                        $controll = $pwmodel->controllHash($passwort, $salt, $user['pwId']);
                        if (!$controll) {
                            // Fehlermeldung, falls die Kontrolle negative ausgefallen ist
                            $strErrorDesc = "Passwort ist falsch";
                            $strErrorHeader = $this->fehler(401);
                        } else {
                            // Aktive Session setzen
                            $this->createUserSession($user['id'], $user['email'], $user['name'], $user['role']);
                            // Antwort mit aktiver Rolle
                            $answer = [
                                "success" => 1,
                                "role" => $user['role'],
                            ];
                            $responseData = json_encode($answer);
                        }
                    }
                }
            } else {
                // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
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
    public function checkAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine GET_Methode ist
            if (strtoupper($requestMethod) == 'GET') {
                // Überprüfung ob Session schon existiert und übereinstimmt
                if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
                    // positive Antwort mit Aktiver Rolle wird zurückgesendet
                    $answer = [
                        "success" => 1,
                        "role" => $_SESSION['user_role'],
                    ];
                    $responseData = json_encode($answer);
                } else {
                    // negative Antwort ohne Rolle wird zurückgesendet
                    $answer = [
                        "success" => 0,
                        "role" => '',
                    ];
                    $responseData = json_encode($answer);
                }
            } else {
                // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
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
    public function logoutAction()
    {
        $strErrorDesc = '';
        // Kommunikations-Methode entnehmen
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        try {
            // abfrage ob es eine POST_Methode ist
            if (strtoupper($requestMethod) == 'POST') {
                // Überprüfung ob Session Aktive ist
                if (session_status() == 2) {
                    // Überprüfung ob Session existiert und übereinstimmt
                    if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
                        // löschen aller Session Variablen
                        session_unset();
                        // löschen aller existierenden Daten dieser Session
                        session_destroy();
                        // loging Session Status
                        error_log(session_status());
                        // Antwort vorbereitung
                        $answer = [
                            "success" => 0, // Damit Frontend einträge löscht
                            "role" => '',
                        ];
                        $responseData = json_encode($answer);
                    } else {
                        // Fehlermeldung, falls ein serverseitiger Fehler entstanden ist
                        $strErrorDesc = 'Something went wrong! Please contact support.';
                        $strErrorHeader = $this->fehler(500);
                    }
                }
            } else {
                // Fehlermeldung, falls eine nicht unterstütze Kommunikations-Methode verwendet wurde
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = $this->fehler(422);
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
}
?>