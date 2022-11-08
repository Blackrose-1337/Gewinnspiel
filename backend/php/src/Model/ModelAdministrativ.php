<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
*
*/


class ModelAdministrative extends ModelBase
{
    private string $email;
    private string $rolle;
    private int $pwSaltId;

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of rolle
     */ 
    public function getRolle()
    {
        return $this->rolle;
    }

    /**
     * Set the value of rolle
     *
     * @return  self
     */ 
    public function setRolle($rolle)
    {
        $this->rolle = $rolle;

        return $this;
    }

    /**
     * Get the value of pwSaltId
     */ 
    public function getPwSaltId()
    {
        return $this->pwSaltId;
    }

    /**
     * Set the value of pwSaltId
     *
     * @return  self
     */ 
    public function setPwSaltId($pwSaltId)
    {
        $this->pwSaltId = $pwSaltId;

        return $this;
    }
}