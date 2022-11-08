<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
*
*/


class ModelProject extends ModelBase
{
    private int $userId;
    private int $textId;
     

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
     * Get the value of textId
     */ 
    public function getTextId()
    {
        return $this->textId;
    }

    /**
     * Set the value of textId
     *
     * @return  self
     */ 
    public function setTextId($textId)
    {
        $this->textId = $textId;

        return $this;
    }
}