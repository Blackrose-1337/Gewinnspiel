<?php
/*
Hauptcontroller mit bestimmten methoden
*/
class BaseController
{
    public function __call($name, $args)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri;
    }

    protected function getQueryStringParams()
    {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }


    protected function sendOutput($data, $httpHeaders = array())
    {
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        error_log("-------------------------sendet DATA----------------------------");
        error_log("----------------------------------------------------------------");
        // error_log($data);
        error_log("----------------------------------------------------------------");

        echo $data;
        exit;
    }
    protected function rndtoken()
    {
        $bytes = random_bytes(16);
        $str = bin2hex($bytes);

        return $str;
    }

    // Fehler Liste und abruf
    protected function fehler($nr)
    {
        switch ($nr) {
            case 420:
                return "HTTP/1.1 420 Die angeforderte Ressource unterstuetzt einen oder mehrere der angegebenen Parameter nicht.";
            case 406:
                return "HTTP/1.1 406 Sie sind bereits angemeldet";
            case 422:
                return "HTTP/1.1 422 Unprocessable Entity";
            case 500:
                return "HTTP/1.1 500 Internal Server Error";
            case 405:
                return "HTTP/1.1 405 Nicht aktzeptierte Session";
            case 401:
                return "HTTP/1.1 401 Unautorisiert";

        }
    }

    // Success abruf
    protected function success($nr)
    {
        switch ($nr) {
            case 200:
                return "200";
        }
    }

    protected function countfolder($dir)
    {
        if (is_dir($dir)) {
            $counter = 0;
            chdir($dir);
            $handle = opendir(".");
            while ($file = readdir(($handle))) {
                if (is_dir($file) && $file != "." && $file != "..") {
                    $counter++;
                }
            }
            return $counter;
        }
    }

    protected function saveImage($picturebase64, $path, $projectid)
    {
        $modelimage = new ModelBilder;
        $count = 0;
        foreach ($picturebase64 as $base64) {

            $picture = explode(',', $base64['bildbase']);
            error_log('---------------------------------------------------------------');
            error_log(json_encode($picture));
            error_log('---------------------------------------------------------------');
            $newpath = $path . "/Image" . $count . ".png";
            $img = imagecreatefromstring(base64_decode($picture[1]));
            imagepng($img, $newpath, 0);
            $count++;
            $modelimage->createImagePath($projectid, $newpath);
        }
    }

    protected function getImage($path)
    {
        $handle = file_get_contents(('../' . $path));
        $img = (base64_encode($handle));
        $test = [
            'img' => $img,
        ];
        //error_log(json_encode($test));
        error_log('------ give Picture');
        return $test;
    }

    protected function sendmail($empfaenger, $link, $pw)
    {
        // Betreff
        $empfaenger = 'yannick-basler@gmx.ch';
        $betreff = 'Bestätigungsmail Stickstoff Wettbewerb';
        $link = "http://localhost:8000/src/index.php/competition/confirm/token";
        // Nachricht
        $nachricht = '
        <html>
            <head>
                <title>Bestätigung Stickstoff Wettbewerb</title>
            </head>
            <body>
                <p>Mit dem folgenden Link bestätigen Sie, dass Sie sich an dem Wettbewerb angemeldet haben.</p></br>
                <h4>' . '<a href=' . $link . '>Bestätigungslink</a>' . '</h4></br></br>
                <p>Hier folgt noch ihr Passwort mit dem Sie sich Anmelden können auf der Seite, um ihr Projekt nochmals einzusehen und gegebenenfalls Änderungen machen können.</p></br>
                <h4>' . $pw . '</h4>
            </body>
        </html>
        ';

        // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
        $header[] = 'MIME-Version: 1.0';
        $header[] = 'Content-type: text/html; charset=iso-8859-1';

        // zusätzliche Header
        $header[] = 'To:' . $empfaenger;
        $header[] = 'From: Stickstoff Wettbewerb <Stickstoff@Wettbewerb.com>';

        // verschicke die E-Mail
        mail($empfaenger, $betreff, $nachricht, implode("\r\n", $header));
    }

    protected function createUserSession($id, $email, $name, $role)
    {
        $_SESSION['id'] = session_id();
        $_SESSION['user_id'] = $id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;

        return 1;
    }

    protected function sessionCheck()
    {
        if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
            error_log('True Sesssion');
            return 1;
        } else {
            error_log('False Session');
            return 0;
        }
    }

    protected function userCheck($val1, $val2 = "1", $val3 = "2")
    {
        switch ($_SESSION['user_role']) {
            case $val1:
                error_log('True role');
                return 1;
            case $val2:
                error_log('True role');
                return 1;
            case $val3:
                error_log('True role');
                return 1;
            default:
                return 0;
        }
    }

}