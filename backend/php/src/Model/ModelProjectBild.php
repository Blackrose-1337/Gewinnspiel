<?php

class ModelProjectBild extends ModelBase
{
    //Attribute
    private int $projectId;
    private int $bilderpfadId;

  

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

    /**
     * Get the value of projectId
     */ 
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set the value of projectId
     *
     * @return  self
     */ 
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }
}

?>