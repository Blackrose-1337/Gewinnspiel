<?php
// zusätzlicher Aufruf der benötigten Modele zum abruf von Funktionen
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
class ModelBewertung extends ModelBase
{
    //Attribute
    private int $administrativeId;
    private int $userId;

    // holt Kriterien von DB
    public function getKriterien()
    {
        $this->db->query("SELECT * FROM Kriterien");
        $data = $this->db->resultSet();
        return $data;
    }

    // holt alle Bewertungen, bei dennen Projekt-ID mit Project-ID(DB) übereinstimmt und User-ID mit Administrative-ID(DB) übereinstimmt
    public function getBewertung($data)
    {
        $this->db->query("SELECT * FROM Bewertung
        WHERE administrativeId= :administrativeId AND projectId= :projectId");
        $this->db->bind(":projectId", $data['projectId']);
        $this->db->bind(":administrativeId", $_SESSION["user_id"]);
        $data = $this->db->resultSet();
        return $data;
    }

    // gibt eine Summe der Bewertungspunkte für jedes Projekt in der Tabelle "Bewertung" berechnet, gruppiert nach Projekt-ID
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
}

?>