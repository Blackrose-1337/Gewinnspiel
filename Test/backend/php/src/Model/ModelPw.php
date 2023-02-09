<?php

class ModelPw extends ModelBase
{
    //Attribute
    private string $hash;


    // Hash reset
    public function resetHashbyId(int $salt, int $id)
    {
        $pw = $this->getString();
        $hash = $this->mySha512($pw, $salt, 10000);

        $this->db->query("UPDATE Pw SET hash = :hash WHERE id = :id");
        $this->db->bind(":hash", $hash);
        $this->db->bind(":id", $id);
        $this->db->execute();

        return $pw;
    }

    // Hash generierung
    private function mySha512($str, $salt, $iterations)
    {
        for ($x = 0; $x < $iterations; $x++) {
            $str = hash('sha512', $str . $salt);
        }
        return $str;
    }

    // Hash vergleich
    public function controllHash($pw, float $salt, $pwid)
    {
        $hash = $this->mySha512($pw, $salt, 10000);
        $dbhash = $this->getDBHash($pwid);

        if ($dbhash === $hash) {
            return 1;
        } else {
            return 0;
        }

    }

    // Hash auf DB hinterlegen
    public function generateHashDB(string $pw, $salt)
    {
        // generieren des hashes mit string, salt und 10000 durchläufen
        $hash = $this->mySha512($pw, $salt, 10000);

        // Eintragsvorbereitung für hash in der Datenbank in der Tabele Pw
        $this->db->query("INSERT INTO Pw (hash) Values (:hash)");
        $this->db->bind(":hash", $hash);

        //ausführung
        return $this->db->execute();
    }


    // Hash von DB holen
    private function getDBHash($pwid)
    {
        $this->db->query("SELECT hash FROM Pw WHERE id = $pwid");
        $hash = $this->db->resultSet();
        return $hash[0]['hash'];
    }

    /**
     * Get the value of hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the value of hash
     *
     * @return  self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }
}

?>