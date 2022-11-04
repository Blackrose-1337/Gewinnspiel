<?php
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Origin: http://localhost:3000");
// header('Content-Type: application/json');
// header('Accept: application/json');
// $requestmethode=   $_SERVER['REQUEST_METHODE'];
// $requesturl = $_SERVER['REQUEST_URI'];
// $json = '{
//     "id": 2,
//     "title": "PHP",
//     "site": "GeeksforGeeks",
//     "url": "'.$requesturl.'",
//     "methode": "'.$requestmethode.'",
// }';

// $json_decoded = json_decode($json);
// print_r($json_decoded);
// echo $json;

class Controller
{
    
    protected function model($model)
    {

        if (file_exists('../Model/' . $model . '.php'))
        {
            require_once '../Model/' . $model . '.php';
            return new $model();
        }
        else {
            echo 'Error : Model does not exists!';
        }
    }    
}
 
?>
