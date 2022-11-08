<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
*
*/


class ModelPwSalt extends ModelBase
{
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

    public function getFakeData(){
        $data = ['id' => $this->getFakeId(),'pwId'=> $this->getFakeId(), 'saltId'=> $this->getFakeId()];
        return $data;
    }
}
