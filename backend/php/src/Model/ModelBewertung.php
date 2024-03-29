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
	public function getMissingProject(){
		$this->db->query("SELECT u.name, u.surname, GROUP_CONCAT(DISTINCT p.id) AS project_ids
        FROM User u
        JOIN Project p ON u.role IN ('jury')
        LEFT JOIN Bewertung b ON p.id = b.projectid AND b.administrativeId = u.id
        WHERE b.id IS NULL OR b.finish = 0
        GROUP BY u.id;
    ");
		return $this->db->resultSet();
	}



	/**
	 * Überprüfung ob Bewertung bereits existiert mittels Projekt-ID
	 * @param $projectId int Projekt-ID
	 * @return bool true wenn Bewertung existiert, false wenn nicht
	*/
	public function checkBewertung(int $projectId): bool
	{
		$this->db->query("SELECT * FROM Bewertung
		WHERE projectId= :projectId");
		$this->db->bind(":projectId", $projectId);
		$data = $this->db->resultSet();
		if (empty($data)) {
			return false;
		} else {
			return true;
		}
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

	private function checkSetBewertungen(int $projectId, int $administrativeId): int
	{
		$this->db->query("SELECT * FROM Bewertung
		WHERE projectId= :projectId AND administrativeId = :administrativeId");
		$this->db->bind(":projectId", $projectId);
		$this->db->bind(":administrativeId", $administrativeId);
		$data = $this->db->resultSet();
		return count($data);
	}

    // Speichert Bewertung auf der DB
    public function createOrUpdateBewertung($data): int
    {
		if ($data["id"] == 0 && $this->checkSetBewertungen($data["projectId"], $_SESSION["user_id"]) < 4) {

            $this->db->query("INSERT INTO Bewertung
            (`administrativeId`,`projectId`,`kriterienId`,`bewertung`,`finish`)
            VALUES (:administrativeId, :projectId, :kriterienId, :bewertung, :finish)");
            $this->db->bind(":administrativeId", $_SESSION["user_id"]);
            $this->db->bind(":projectId", $data["projectId"]);
            $this->db->bind(":kriterienId", $data["kriterienId"]);
            $this->db->bind(":bewertung", $data["bewertung"]);
            $this->db->bind(":finish", $data["finish"]);
        } else {
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