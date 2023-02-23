<?php

class ModelBilder extends ModelBase
{
    //Attribute
    private string $bilderpfad;
    private int $projektId;


    public function createImagePath($projectid, $path)
    {
        $this->db->query("INSERT INTO Image
        (`projectid`, `path`)
        VALUES (:projectid, :path)");
        $this->db->bind(":projectid", $projectid);
        $this->db->bind(":path", $path);
        $answer = $this->db->execute();
        return $answer;
    }
    public function getPictureByProId($proid)
    {
        $this->db->query("SELECT * FROM Image
        WHERE projectid = :projectid");
        $this->db->bind(":projectid", $proid);
        $data = $this->db->resultSet();
        return $data;
    }

    public function getDeletePath($id)
    {
        $ans = $this->getPictureByProId($id);
        $temp = explode('/', $ans[0]['path']);
        return $temp[0] . '/' . $temp[1] . '/' . $temp[2];
    }

    public function getAllPaths()
    {
        $this->db->query("SELECT * FROM Image");
        $data = $this->db->resultSet();
        return $data;
    }
    /**
     * Get the value of bilderpfad
     */
    public function getBilderpfad()
    {
        return $this->bilderpfad;
    }

    /**
     * Set the value of bilderpfad
     *
     * @return  self
     */
    public function setBilderpfad($bilderpfad)
    {
        $this->bilderpfad = $bilderpfad;

        return $this;
    }

    /**
     * Get the value of projektId
     */
    public function getProjektId()
    {
        return $this->projektId;
    }

    /**
     * Set the value of projektId
     *
     * @return  self
     */
    public function setProjektId($projektId)
    {
        $this->projektId = $projektId;

        return $this;
    }
}

?>