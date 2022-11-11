<?php
define('PROJECT_ROOT_PATH', __DIR__ . '/../');
require_once PROJECT_ROOT_PATH . "Controller/API/BaseController.php";
// require_once PROJECT_ROOT_PATH . "inc/config.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// }
switch ($uri[3]) {
    case 'user':
        require_once PROJECT_ROOT_PATH . "Model/ModelTeilnehmende.php";
        break;
    case 'competition':
        require_once PROJECT_ROOT_PATH . "Model/ModelCompetition.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelProject.php";
        require_once PROJECT_ROOT_PATH . "Model/ModelTeilnehmende.php";
        break;
    case 'project':
        require_once PROJECT_ROOT_PATH . "Model/ModelProject.php";
        break;
    case 'evaluation':
        require_once PROJECT_ROOT_PATH . "Model/ModelEvaluation.php";
        break;
    default:
        header("Page can’t be found", true, 404);

}


?>