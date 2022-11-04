<?php

class ModelBewertung extends ModelBase
{
    //Attribute
    private int $administrativeId;
    private int $userId;
    private int $bewertungsId;

    /**
     * Get the value of administrativeId
     */ 
    public function getAdministrativeId()
    {
        return $this->administrativeId;
    }

    /**
     * Set the value of administrativeId
     *
     * @return  self
     */ 
    public function setAdministrativeId($administrativeId)
    {
        $this->administrativeId = $administrativeId;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of bewertungsId
     */ 
    public function getBewertungsId()
    {
        return $this->bewertungsId;
    }

    /**
     * Set the value of bewertungsId
     *
     * @return  self
     */ 
    public function setBewertungsId($bewertungsId)
    {
        $this->bewertungsId = $bewertungsId;

        return $this;
    }
}

?>