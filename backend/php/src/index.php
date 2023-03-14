<?php
// env auslesen
$CORS_ORIGIN_ALLOWED = "*";


if(file_exists('.env')){
$env = parse_ini_file('.env');
}elseif (file_exists('../../../.env')){
    $env = parse_ini_file('../../../.env');

} else {
    $env = false;
}

if ($env){

    putenv("DB_HOST=".$env['DB_HOST']);
    putenv("DB_USERNAME=".$env['DB_USERNAME']);
    putenv("DB_PASSWORD=".$env['DB_PASSWORD']);
    putenv("DB_DATABASE_NAME=".$env['DB_DATABASE_NAME']);
    putenv("ENVIRONMENT=".$env['ENVIRONMENT']);
    putenv("F_PATH=".$env['F_PATH']);
    $allowedOrigins = $env["CORS_ALLOWED_ORIGINS"];
    header("Access-Control-Allow-Origin: $allowedOrigins");
}


// Sesssion Initialisierung
require_once __DIR__ . '/helpers/session_helper.php';
// header setzen
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methodes: GET, POST, OPTIONS");
header('Content-Type: application/json');
header('Accept: application/json');

// Dateien initialisieren
require __DIR__ . "/inc/bootstrap.php";
//require __DIR__ . "/inc/config.php";

// URL-Pfad abrufen und auf Variable setzen
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// URL auftrennen
$uri = explode('/', $uri);

// mit drittem Element der URL Controller nach SwitchCase Übereinstimmung initialisieren
switch ($uri[2]) {
    case 'user':
        require __DIR__ . "/Controller/API/UserController.php";
        $objFeedController = new UserController();
        break;
    case 'competition':
        require __DIR__ . "/Controller/API/CompetitionController.php";
        $objFeedController = new CompetitionController();
        break;
    case 'project':
        require __DIR__ . "/Controller/API/ProjectController.php";
        $objFeedController = new ProjectController();
        break;
    case 'evaluation':
        require __DIR__ . "/Controller/API/EvaluationController.php";
        $objFeedController = new EvaluationController();
        break;
    case 'admin':
        require __DIR__ . "/Controller/API/AdminController.php";
        $objFeedController = new AdminController();
        break;
    case 'auth':
        require __DIR__ . "/Controller/API/AuthController.php";
        $objFeedController = new AuthController();
        break;
    case 'confirm':
        require __DIR__ . "/Controller/API/ConfirmController.php";
        $objFeedController = new ConfirmController();
        break;
    default: // Ausgabe bei nicht zutreffender URL
        header("Page can’t be found", true, 404);

}

// Variable wirt mit dem vierten Element der URL geführt mit dem Anhang 'Action'
$strMethodName = $uri[3] . 'Action';
// fügt dem initalisierten Controller das Argument hinzu strMethodeName
$objFeedController->{$strMethodName}();
?>