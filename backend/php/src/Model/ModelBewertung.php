<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
class ModelBewertung extends ModelBase
{
    //Attribute
    private int $administrativeId;
    private int $userId;

    // Holt Kriterien von DB
    public function getKriterien()
    {
        $this->db->query("SELECT * FROM Kriterien");
        $data = $this->db->resultSet();
        return $data;
    }

    public function getBewertung($data)
    {
        $this->db->query("SELECT * FROM Bewertung
        WHERE administrativeId= :administrativeId AND projectId= :projectId");
        $this->db->bind(":projectId", $data['projectId']);
        $this->db->bind(":administrativeId", $_SESSION["user_id"]);
        $data = $this->db->resultSet();
        return $data;
    }

    public function getAuswertung()
    {
        $this->db->query("SELECT projectId, SUM(bewertung) AS 'value'  
        FROM Bewertung  
        GROUP BY projectId");
        $data = $this->db->resultSet();
        return $data;
    }

    // Speichert Bewertung auf der DB
    public function createOrUpdateBewertung($data)
    {

        if ($data["id"] == 0) {

            $this->db->query("INSERT INTO Bewertung
            (`administrativeId`,`projectId`,`kriterienId`,`bewertung`,`finish`)
            VALUES (:administrativeId, :projectId, :kriterienId, :bewertung, :finish)");
            $this->db->bind(":administrativeId", $_SESSION["user_id"]);
            $this->db->bind(":projectId", $data["projectId"]);
            $this->db->bind(":kriterienId", $data["kriterienId"]);
            $this->db->bind(":bewertung", $data["bewertung"]);
            $this->db->bind(":finish", $data["finish"]);

        } else if ($data["id"] != 0) {
            $this->db->query("UPDATE Bewertung SET
            bewertung = :bewertung, finish = :finish 
            WHERE id= :id");
            $this->db->bind(":bewertung", $data["bewertung"]);
            $this->db->bind(":finish", $data['finish']);
            $this->db->bind(":id", $data["id"]);
        }
        $answer = $this->db->execute();

        // get Id from DB
        $this->db->query("SELECT id FROM User ORDER BY ID DESC LIMIT 1");
        $id = $this->db->resultSet();

        // set Id on Model
        $this->id = $id[0]['id'];
        return $answer;
    }

    // Testfunktionen
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