<?php

class ModelAdministrativePwSalt extends ModelBase
{
    //Attribute
    private int $pwId;
    private int $saltId;

    /**
     * Get the value of pwId
     */ 
    public function getPwId()
    {
        return $this->pwId;
    }

    /**
     * Set the value of pwId
     *
     * @return  self
     */ 
    public function setPwId($pwId)
    {
        $this->pwId = $pwId;

        return $this;
    }

    /**
     * Get the value of saltId
     */ 
    public function getSaltId()
    {
        return $this->saltId;
    }

    /**
     * Set the value of saltId
     *
     * @return  self
     */ 
    public function setSaltId($saltId)
    {
        $this->saltId = $saltId;

        return $this;
    }
}

?>