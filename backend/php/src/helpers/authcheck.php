<?php
class Authcheck
{

    function authcheck()
    {
        $requestHeaders = apache_request_headers();
        $token = $this->getBearerToken();
        $modelbase = new BaseController;

        if (!in_array('user_id', $_SESSION)) {

            if (!in_array('token', $_SESSION)) {
                $model = new ModelTeilnehmende;
                $model->createUserSession(0, 'guest', 'guest', 'guest', '');
                print_r($_SESSION['user_id']);
                header("Authorization: Bearer " . $_SESSION['token']);
            }
        } elseif ($_SESSION['token'] != $token) {
            return $modelbase->fehler(405);
        } elseif ($_SESSION['token'] == $token) {
            return 1;
        } else {
            return $modelbase->fehler(500);
        }
    }
    private function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    /**
     * get access token from header
     * */
    private function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
    }
}
?>