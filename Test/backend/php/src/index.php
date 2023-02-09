<?php
// Sesssion 
require_once __DIR__ . '/helpers/session_helper.php';

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methodes: GET, POST, OPTIONS");
header('Content-Type: application/json');
header('Accept: application/json');
require __DIR__ . "/inc/bootstrap.php";
require __DIR__ . "/inc/config.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

switch ($uri[3]) {
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
    default:
        header("Page can’t be found", true, 404);

}

$strMethodName = $uri[4] . 'Action';
$objFeedController->{$strMethodName}();
?>