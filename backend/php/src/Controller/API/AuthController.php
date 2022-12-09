<?php
class AuthController extends BaseController
{
    // Funktion um ein Projekt abzurufen
    public function LoginAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();

        // abfrage ob es eine GET_Methode ist
        if (strtoupper($requestMethod) == 'POST') {
            try {

                if (isset($_SESSION['user_id'])) {
                    $strErrorDesc = 'Sie sind bereits angemeldet';
                    $strErrorHeader = $this->fehler(406);
                } else {
                    // Aufruf benötigter Klassen 


                    $data = json_decode(file_get_contents('php://input'), true);
                    $email = isset($data['email']) ? $data['email'] : "";
                    $passwort = isset($data['password']) ? $data['password'] : "";

                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]+$/", $email)) {
                        $strErrorDesc = 'Ungültige E-Mail';
                        $strErrorHeader = $this->fehler(420);
                    } elseif (strlen($passwort) < 12 || !preg_match("/^[a-zA-Z0-9\?\!\+\@]/", $passwort)) {

                        $strErrorDesc = 'Das Passwort ist kürzer als 12 Zeichen oder enthält nicht erlaubte Zeichen';
                        $strErrorHeader = $this->fehler(420);
                    }


                    $responseData = true;
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