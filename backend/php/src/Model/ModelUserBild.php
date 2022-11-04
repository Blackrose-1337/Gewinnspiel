<?php

class ModelUserBild extends ModelBase
{
    //Attribute
    private int $teilnehmendeId;
    private int $bilderpfadId;

    /**
     * Get the value of teilnehmendeId
     */ 
    public function getTeilnehmendeId()
    {
        return $this->teilnehmendeId;
    }

    /**
     * Set the value of teilnehmendeId
     *
     * @return  self
     */ 
    public function setTeilnehmendeId($teilnehmendeId)
    {
        $this->teilnehmendeId = $teilnehmendeId;

        return $this;
    }

    /**
     * Get the value of bilderpfadId
     */ 
    public function getBilderpfadId()
    {
        return $this->bilderpfadId;
    }

    /**
     * Set the value of bilderpfadId
     *
     * @return  self
     */ 
    public function setBilderpfadId($bilderpfadId)
    {
        $this->bilderpfadId = $bilderpfadId;

        return $this;
    }
}

?>