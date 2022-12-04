<?php

class ModelBase
{
    private int $id = 42;
    protected $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    protected function getFakeId()
    {
        return rand(0, 200);
    }

    protected function getString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 12; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }



    protected function sonderzeichen($string)
    {
        $string = str_replace("ä", "ae", $string);
        $string = str_replace("ü", "ue", $string);
        $string = str_replace("ö", "oe", $string);
        $string = str_replace("Ä", "Ae", $string);
        $string = str_replace("Ü", "Ue", $string);
        $string = str_replace("Ö", "Oe", $string);
        $string = str_replace("ß", "ss", $string);
        return $string;
    }
    protected function getById($arrays, $id)
    {
        foreach ($arrays as $array) {
            if ($array['id'] == $id)
                return $array;
        }
        return null;
    }
}

?>