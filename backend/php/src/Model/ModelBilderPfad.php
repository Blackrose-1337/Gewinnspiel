<?php

class ModelBilder extends ModelBase
{
    //Attribute
    private string $bilderpfad;
    private int $projektId;

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

    /**
     * Get the value of projektId
     */
    public function getProjektId()
    {
        return $this->projektId;
    }

    /**
     * Set the value of projektId
     *
     * @return  self
     */
    public function setProjektId($projektId)
    {
        $this->projektId = $projektId;

        return $this;
    }
}

?>