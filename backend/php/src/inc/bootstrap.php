<?php

// Variable für den Root Path setzen
define('PROJECT_ROOT_PATH', __DIR__ . "/../");

// Dateien initialisieren
require_once PROJECT_ROOT_PATH . "Controller/API/BaseController.php";
require_once PROJECT_ROOT_PATH . "Model/Database.php";
require_once PROJECT_ROOT_PATH . "PHPMailer-master/src/Exception.php";
require_once PROJECT_ROOT_PATH . "PHPMailer-master/src/PHPMailer.php";

// URL-Pfad abrufen und auf Variable setzen
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// URL auftrennen
$uri = explode('/', $uri);
// mit drittem Element der URL Modele(Klassen) nach SwitchCase Übereinstimmung initialisieren
switch ($uri[2]) {
	case 'auth':
	case 'confirm':
	case 'user':
        require_once PROJECT_ROOT_PATH . "Model/ModelTeilnehmende.php";
        break;
    case 'competition':
        require_once PROJECT_ROOT_PATH . "Model/ModelCompetition.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelProject.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelTeilnehmende.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelBilder.php";
        break;
    case 'project':
        require_once PROJECT_ROOT_PATH . "Model/ModelProject.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelBilder.php";
		require_once PROJECT_ROOT_PATH . "Model/ModelBewertung.php";
		require_once PROJECT_ROOT_PATH . "Model/ModelTeilnehmende.php";
        break;
    case 'evaluation':
        require_once PROJECT_ROOT_PATH . "Model/ModelBewertung.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelProject.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelBilder.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelTeilnehmende.php";

        break;
    case 'admin':
        require_once PROJECT_ROOT_PATH . "Model/ModelTeilnehmende.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelPw.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelSalt.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelProject.php";
	    require_once PROJECT_ROOT_PATH . "Model/ModelBewertung.php";
        break;
	default: // Ausgabe bei nicht zutreffender URL
        header("Page can’t be found", true, 404);
}
?>