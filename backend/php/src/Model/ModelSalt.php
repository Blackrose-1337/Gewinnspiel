<?php

class ModelSalt extends ModelBase
{
    //Attribute
    private int $salt;

    // neuer Salt wird generiert und auf der DB überschrieben
    public function resetSaltbyID($id): int
    {
        // generiert neuen Salt
        $salt = $this->randomSalt();
        // überschreiben auf der DB
        $this->db->query("UPDATE Salt SET salt = :salt WHERE id = :id");
        $this->db->bind(":salt", $salt);
        $this->db->bind(":id", $id);
        return $this->db->execute();
    }

    // Salt generieren
    protected function randomSalt()
    {
        return rand(1000000000, 9999999999);
    }

    // Salt wird auf der DB eingetragen
    public function createSaltDB()
    {
        // salt generieren
        $salt = $this->randomSalt();
        // salt auf DB speichern
        $this->db->query("INSERT INTO Salt (salt) Values (:salt)");
        $this->db->bind(":salt", $salt);
        return $this->db->execute();
    }

    // holt Salt von der DB mit ID
    public function getSaltbyID($id)
    {
        $this->db->query("SELECT salt FROM Salt WHERE id= $id");
        $salt = $this->db->resultSet();
        return $salt[0]['salt'];
    }

    // Salt von DB Löschen
    public function deleteSaltDB($id)
    {
        $this->db->query("DELETE FROM Salt WHERE id = :id");
        $this->db->bind(":id", $id);
        return $this->db->execute();
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

    /**
     * @return int
     */
    public function getSalt(): int
    {
        return $this->salt;
    }
}

?>