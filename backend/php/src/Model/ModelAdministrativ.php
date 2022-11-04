<?php

class ModelAdministrativ extends ModelBase
{
    //Attribute
    private string $email;
    private string $rolle;
    private int $administrativPwSaltId;

    /**
     * Get the value of administrativPwSaltId
     */ 
    public function getAdministrativPwSaltId()
    {
        return $this->administrativPwSaltId;
    }

    /**
     * Set the value of administrativPwSaltId
     *
     * @return  self
     */ 
    public function setAdministrativPwSaltId($administrativPwSaltId)
    {
        $this->administrativPwSaltId = $administrativPwSaltId;

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
}

?>