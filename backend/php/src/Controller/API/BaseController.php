<?php
// define('PROJECT_ROOT_PATH', __DIR__ . "/../../");
// require_once PROJECT_ROOT_PATH . "PHPMailer-master/src/Exception.php";
// require_once PROJECT_ROOT_PATH . "PHPMailer-master/src/PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



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
                return "HTTP/1.1 200 OK";
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

    protected function saveImage($picturebase64, $path, $projectid, $number = 1)
    {
        $modelimage = new ModelBilder;
        $count = $number;

        foreach ($picturebase64 as $base64) {
            $picture = explode(',', $base64['bildbase']);
            $newpath = $path . "/image" . $count . ".png";
            $ifp = fopen($newpath, 'w');
            fwrite($ifp, base64_decode($picture[1]));
            fclose($ifp);
            $count++;
            $modelimage->createImagePath($projectid, $newpath);
        }
    }

    protected function getImage($path)
    {
        $answer = [
            'img' => $path,
        ];
        return $answer;
    }
    protected function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
    protected function sendmail($empfaenger, $link, $pw, $name, $surname, $date)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isMail();
            $date = date("d-m-Y", strtotime($date));
            // Betreff
            $betreff = 'Bestätigungsmail Stickstoff Wettbewerb';
            // Link anpassung
            $link = "https://gewinnspiel.stickstoff-magazin.de/" . $link;
            // Nachricht
            $nachricht = '<!DOCTYPE html>
            <html lang="de"> 
        <body>

        <p>Liebe*r ' . $name . ' ' . $surname . '</p>
        <p>Vielen Dank für die Teilnahme am grossen stickstoff-Magazin Gewinnspiel.</p>
        <p>Bitte bestätigen Sie mit klick auf folgenden Link ihre E-Mail-Adresse, erst nach dieser Bestätigung können Sie am Gewinnnspiel teilnehmen.</br>
        <a href=' . $link . '>Bestätigungslink</a></p>
        <p>Mit Ihrer Teilnahme wurde automatisch ein Account angelegt, mit dem Ihren Beitrag falls nötig nochmal anpassen können. Dies ist bis zum Teilnahmeschluss des Gewinnspiels am ' . $date . ' möglich.</p>
        <p> Sie können sich unter https://gewinnspiel.stickstoff-magazin.de/login mit folgenden Zugangsdaten anmelden:</br>
        Benutzer: ' . $empfaenger . '</br>
        Passwort: ' . $pw . '</p>
       
        <p>Das stickstoff-Magazin Team wünscht Ihnen viel Erfolg!</p>
        </body>
        </html>'
            ;
            // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
            $mail->Host = 'localhost'; // Hier die IP-Adresse oder Domain des Mail-Servers eintragen

            // Empfänger und Inhalt
            $mail->setFrom('noreply@stickstoff-magazin.de', 'Stickstoff-Magazin');
            $mail->CharSet = 'UTF-8';
            $mail->isHtml(true);
            $mail->addAddress($empfaenger);
            $mail->Subject = $betreff;
            $mail->Body = $nachricht;
            $mail->send();
        } catch (Exception $e) {
            error_log('Die E-Mail konnte nicht gesendet werden. Fehlermeldung: ', $mail->ErrorInfo);
        }
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
            return 1;
        } else {
            return 0;
        }
    }

    protected function userCheck($val1, $val2 = "1", $val3 = "2")
    {
        switch ($_SESSION['user_role']) {
            case $val1:
                return 1;
            case $val2:
                return 1;
            case $val3:
                return 1;
            default:
                return 0;
        }
    }
}