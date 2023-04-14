<?php

class ModelBase
{
    private int $id;
    protected $db;

    // Database Initialisierung
    public function __construct()
    {
        $this->db = new Database;
    }

    // zufälliges Passwort generieren
    protected function getString()
    {
        // mögliche Zeichen des Passwortes
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^*()_+-={}|:,.<>?';
        $randomString = '';

        // Anzahl wiederholungen genertierter zufälligen Zeichen (Passwortlänge)
        for ($i = 0; $i < 12; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    // Funktion zum herstellen eines Zufälligen Tokens
    protected function rndtoken()
    {
        $bytes = random_bytes(16);
        $str = bin2hex($bytes);

        return $str;
    }

    // Funktion um Sonderzeichen neu zu setzen falls gewünscht für DB einträge
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


}

?>