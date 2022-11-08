<?php
 header("Access-Control-Allow-Credentials: true");
 header("Access-Control-Allow-Origin: http://localhost:3000");
 header('Content-Type: application/json');
 header('Accept: application/json');
require __DIR__ . "/inc/bootstrap.php";
 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );


// if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
//     header("Shit");
//     #echo "index uri = ";
//     exit();
  

// }
 
require PROJECT_ROOT_PATH . "Controller/API/UserController.php";
require PROJECT_ROOT_PATH . "Controller/API/ProjectController.php";
require PROJECT_ROOT_PATH . "Controller/API/EvaluationController.php";
require PROJECT_ROOT_PATH . "Controller/API/AuthController.php";
require PROJECT_ROOT_PATH . "Controller/API/AnalysisController.php";
require PROJECT_ROOT_PATH . "Controller/API/UserVerwaltungController.php";
$objFeedController = new UserController();
$strMethodName = $uri[4] . 'Action';
$objFeedController->{$strMethodName}();
?>