<?php

class ModelSalt extends ModelBase
{
    //Attribute
    private int $salt;

    public function resetSaltbyID(int $id)
    {
        //salt search with id would be here
        $salt = $this->randomSalt();
        return $salt;
    }
    protected function randomSalt()
    {
        return rand(1000000000, 9999999999);
    }
    /**
     * Get the value of salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set the value of salt
     *
     * @return  self
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }
}

?>