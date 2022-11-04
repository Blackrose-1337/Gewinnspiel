<?php

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
    public function test(){
        echo "test";
        return "{
            test: 'dada'
        }";
        
    }
    
}
?>
    
