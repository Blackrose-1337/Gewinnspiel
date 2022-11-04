<?php

class ModelBilderPfad extends ModelBase
{
    //Attribute
    private string $bilderpfad;

    /**
     * Get the value of bilderpfad
     */ 
    public function getBilderpfad()
    {
        return $this->bilderpfad;
    }

    /**
     * Set the value of bilderpfad
     *
     * @return  self
     */ 
    public function setBilderpfad($bilderpfad)
    {
        $this->bilderpfad = $bilderpfad;

        return $this;
    }
}

?>