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
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        var_dump($data);
        exit;
    }
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

        }
    }
    protected function success($nr)
    {
        switch ($nr) {
            case 200:
                return "HTTP/1.1 200 Success with Blackrose";
        }
    }
}