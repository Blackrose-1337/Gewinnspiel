<?php
// Hinzufügen von Klassen um Mail-Funktion zu nutzen
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*
Hauptcontroller mit bestimmten methoden
*/
class BaseController
{
    // Antwort des Servers bei unbekannter URL
    public function __call($name, $args)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    // Auftrennung der URL Segemente
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri;
    }

    // QueryParams entgegennehmen
    protected function getQueryStringParams()
    {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }

    // verpacken und versenden der Antwort zum Frontend
    protected function sendOutput($data, $httpHeaders = array())
    {
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                // header setzen
                header($httpHeader);
            }
        }
        // Daten Schreiben
        echo $data;
        exit;
    }

    // Token Generator
    protected function rndtoken()
    {
        $bytes = random_bytes(16);
        $str = bin2hex($bytes);
        return $str;
    }

    // Fehlerliste
    protected function fehler($nr)
    {
        switch ($nr) {
            // falsche Parameter angaben
            case 420:
                return "HTTP/1.1 420 Die angeforderte Ressource unterstuetzt einen oder mehrere der angegebenen Parameter nicht.";
            // bereits angemeldet
            case 406:
                return "HTTP/1.1 406 Sie sind bereits angemeldet";
            // nicht unterstützte Methode
            case 422:
                return "HTTP/1.1 422 Unprocessable Entity";
            // interner Server Fehler
            case 500:
                return "HTTP/1.1 500 Internal Server Error";
            // ungültige Session
            case 405:
                return "HTTP/1.1 405 Nicht aktzeptierte Session";
            // nicht berechtige Rolle
            case 401:
                return "HTTP/1.1 401 Unautorisiert";
        }
        return false;
    }

    // Success abruf
    protected function success($nr)
    {
        switch ($nr) {
            case 200:
                return "HTTP/1.1 200 OK";
        }
        return false;
    }

    // Funktion zum abspeichern von Bildern
    protected function saveImage($picturebase64, $path, $projectid, $number = 1)
    {
        // Aufruf benötigter Klassen 
        $modelimage = new ModelBilder;
		$modelProject = new ModelProject();

        // Zähler variable für namesgebung
        $count = $number;

        // Array von Bildern durcharbeiten zum abspeichern
        foreach ($picturebase64 as $base64) {
            // Base64 Code trennen von nicht benötigten informationen
            $picture = explode(',', $base64['bildbase']);
			// ändern der Nummerierungsart
	        $newcount = sprintf("%03d", $count);
            // Pfadbestimmung zum abspeichern der Bilder auf dem Server
            $newpath = $path . "/image" . $newcount . ".png";
            // Auf neuem Pfad Datei öffnen zum bearbeiten
            $ifp = fopen($newpath, 'w');
            // Base64code in die geöffnete Datei schreiben
            fwrite($ifp, base64_decode($picture[1]));
            // Datei schliessen (führt zum abspeichern der Datei)
            fclose($ifp);
            // Zähler um 1 erhöhen
            $count++;
            // Model Bilder ansprechen um Pfad auf der Datenbank zu hinterlegen inclusive zugewissem Projekt
            $modelimage->createImagePath($projectid, $newpath);
        }
		$modelProject->setPictureIncrement($projectid, $count -1);
    }

    // Pfad Hinterlegung zur Antwortversendung
    protected function getImage($path)
    {
        $answer = [
            'img' => $path,
        ];
        return $answer;
    }

    // GUID-Generator für Ordner-Beschriftung
    protected function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    // Mailversendung mit Bestätigungslink und Passwort
    protected function sendmail($empfaenger, $link, $pw, $name, $surname, $date)
    {
        // Aufruf benötigter Klassen 
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
        </html>';
            // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
            $mail->Host = 'localhost'; // Hier die IP-Adresse oder Domain des Mail-Servers eintragen
            // Empfänger und Inhalt
            $mail->setFrom('noreply@stickstoff-magazin.de', 'Stickstoff-Magazin', true);
            $mail->CharSet = 'UTF-8';
            $mail->isHtml(true);
	        error_log("sendmail9");
	        try {
		        $mail->addAddress( strval($empfaenger));
	        } catch (Exception $e) {
		        error_log($e);
				$betreff = 'Benachrichtigung: E-Mail-Versand fehlgeschlagen';
		        $nachricht = '<!DOCTYPE html>
<html lang="de">
<body>
	<h2>Benachrichtigung: E-Mail-Versand fehlgeschlagen</h2>
	<p>Guten Tag,</p>
	<p>Leider ist es nicht möglich, eine E-Mail an folgende Adresse zu senden:</p>
	<p><strong>Empfängeradresse:</strong> '. $empfaenger . ' </p>
	<p>Es gab ein Problem beim Senden der E-Mail, das wie folgt beschrieben werden kann:</p>
	<p>' . $e .'</p>
</body>
</html>';
		        $mail->addAddress('it@stickstoff-magazin.de');
				error_log($e);
	        }
            $mail->Subject = $betreff;
            $mail->Body = $nachricht;
            if (getenv('ENVIRONMENT') === 'development'){
                error_log($empfaenger);
                error_log($pw);
            } else {
                $mail->send();
            }
        } catch (Exception $e) {
            error_log('Die E-Mail konnte nicht gesendet werden. Fehlermeldung: ', $mail->ErrorInfo);
        }
    }

    // Mailversendung von neuem Passwort
    protected function sendMailWithNewPW($empfaenger, $pw, $name, $surname)
    {
        // Aufruf benötigter Klassen 
        $mail = new PHPMailer(true);
        try {
            $mail->isMail();
	        $mail->CharSet = "UTF-8";
            // Betreff
            $betreff = 'Neues Passwort Stickstoff Wettbewerb';
            // Nachricht
            $nachricht = '<!DOCTYPE html>
            <html lang="de"> 
        <body>

        <p>Liebe*r ' . $name . ' ' . $surname . '</p>
        <p>Auf Ihren Wunsch hin haben wir ihr Passwort zurückgesetzt.</p>
        Benutzer: ' . $empfaenger . '</br>
        Neues Passwort: ' . $pw . '</p>
       
        <p>Das stickstoff-Magazin Team wünscht Ihnen viel Erfolg!</p>
        </body>
        </html>'
            ;
            // für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
            $mail->Host = 'localhost'; // Hier die IP-Adresse oder Domain des Mail-Servers eintragen

            // Empfänger und Inhalt
            $mail->setFrom('noreply@stickstoff-magazin.de', 'Stickstoff-Magazin');
            $mail->isHtml(true);
            $mail->addAddress($empfaenger);
            $mail->Subject = $betreff;
            $mail->Body = $nachricht;
            if (getenv('ENVIRONMENT') === 'development'){
                error_log($empfaenger);
                error_log($pw);
            } else {
                $mail->send();
            }
        } catch (Exception $e) {
            error_log('Die E-Mail konnte nicht gesendet werden. Fehlermeldung: ', $mail->ErrorInfo);
        }
    }

    // Aktive Session setzen mit Userinformationen
    protected function createUserSession($id, $email, $name, $role)
    {
        $_SESSION['id'] = session_id(); // wird benötigt, sonst wird die Session nicht gehalten
        $_SESSION['user_id'] = $id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        return 1;
    }

    // Überprüfung von mitgegebener PHPSESSID(Session-Id im Cookie) mit aktiver Session-Id
    protected function sessionCheck()
    {
        if (isset($_COOKIE['PHPSESSID']) && isset($_SESSION['id']) && $_COOKIE['PHPSESSID'] == $_SESSION['id']) {
            return 1;
        } else {
            return 0;
        }
    }

    // Überprüfung von übergebenen Rollen mit aktiver Session Rolle
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