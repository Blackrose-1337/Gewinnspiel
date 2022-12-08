<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
class ModelBewertung extends ModelBase
{
    //Attribute
    private int $administrativeId;
    private int $userId;


    public function getFakeKriterien()
    {
        $data = [
            ['id' => 2, 'frage' => 'Was geht?'],
            ['id' => 4, 'frage' => 'Wie geht es?'],
            ['id' => 3, 'frage' => 'Was auch immmer geht?'],
            ['id' => 5, 'frage' => 'Wohin geht es?'],
        ];
        return $data;
    }

    public function getKriterien()
    {
        $this->db->query("SELECT * FROM Kriterien");
        $data = $this->db->resultSet();
        return $data;
    }

    public function createBewertung($data)
    {
        $beispiel = 8;
        $this->db->query("INSERT INTO Bewertung ('administrativeId','projectId','kriterienId','bewertung')
        VALUES (:administrativeId, :projectId, :kriterienId, :bewertung");
        $this->db->bind(":administrativeId", $beispiel);
        $this->db->bind(":administrativeId", $data['projectId']);
        $this->db->bind(":kriterienId", $data['kriterienId']);
        $this->db->bind(":bewertung", $data['bewertung']);

        $answer = $this->db->execute();

        // get Id from DB
        $this->db->query("SELECT id FROM User ORDER BY ID DESC LIMIT 1");
        $id = $this->db->resultSet();

        // set Id on Model
        $this->id = $id[0]['id'];
        return $answer;
    }

    /**
     * Get the value of administrativeId
     */
    public function getAdministrativeId()
    {
        return $this->administrativeId;
    }

    /**
     * Set the value of administrativeId
     *
     * @return  self
     */
    public function setAdministrativeId($administrativeId)
    {
        $this->administrativeId = $administrativeId;

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of bewertungsId
     */
    public function getBewertungsId()
    {
        return $this->bewertungsId;
    }

    /**
     * Set the value of bewertungsId
     *
     * @return  self
     */
    public function setBewertungsId($bewertungsId)
    {
        $this->bewertungsId = $bewertungsId;

        return $this;
    }
}

?>