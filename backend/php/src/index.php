<?php
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methodes: GET, POST, OPTIONS");
header('Content-Type: application/json');
header('Accept: application/json');
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


// if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
//     header("Shit");
//     #echo "index uri = ";
//     exit();


// }
switch ($uri[3]) {
    case 'user':
        require PROJECT_ROOT_PATH . "Controller/API/UserController.php";
        $objFeedController = new UserController();
        break;
    case 'competition':
        require PROJECT_ROOT_PATH . "Controller/API/CompetitionController.php";
        $objFeedController = new CompetitionController();
        break;
    case 'project':
        require PROJECT_ROOT_PATH . "Controller/API/ProjectController.php";
        $objFeedController = new ProjectController();
        break;
    case 'evaluation':
        require PROJECT_ROOT_PATH . "Controller/API/EvaluationController.php";
        $objFeedController = new EvaluationController();
        break;
    default:
        header("Page can’t be found", true, 404);

}

// require PROJECT_ROOT_PATH . "Controller/API/AuthController.php";
// require PROJECT_ROOT_PATH . "Controller/API/AnalysisController.php";
// require PROJECT_ROOT_PATH . "Controller/API/UserVerwaltungController.php";


$strMethodName = $uri[4] . 'Action';
$objFeedController->{ $strMethodName}();
?>