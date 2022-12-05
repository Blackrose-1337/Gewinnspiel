<?php

class ModelSalt extends ModelBase
{
    //Attribute
    private int $salt;

    public function resetSaltbyID(int $id)
    {
        $salt = $this->randomSalt();
        $this->db->query("UPDATE Salt SET salt = :salt WHERE id = :id");
        $this->db->bind(":salt", $salt);
        $this->db->bind(":id", $id);
        return $this->db->execute();
    }
    protected function randomSalt()
    {
        return rand(1000000000, 9999999999);
    }

    public function createSaltDB()
    {
        $salt = $this->randomSalt();
        $this->db->query("INSERT INTO Salt (salt) Values (:salt)");
        $this->db->bind(":salt", $salt);
        return $this->db->execute();
    }

    /**
     * Get the value of salt
     */
    public function getSaltbyID($id)
    {
        $this->db->query("SELECT salt FROM Salt WHERE id= $id");
        $salt = $this->db->resultSet();
        return $salt[0]['salt'];
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