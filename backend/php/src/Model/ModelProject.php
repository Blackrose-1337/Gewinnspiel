<?php

// zusätzlicher Aufruf der benötigten Modele zum abruf von Funktionen
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
require_once PROJECT_ROOT_PATH . "Model/ModelBilder.php";
/**
 *
 */


class ModelProject extends ModelBase
{
    private int $userId;
    private string $title;
    private string $text;
	private int $pictureIncrement;

    // holt alle Projekte von DB
    public function getAllProject()
    {
        $this->db->query("SELECT * FROM Project");
        return $this->db->resultSet();
    }
    public function getAllProjectwithfinish()
    {
        $this->db->query("SELECT * FROM Project WHERE finish=1");
        $datas =  $this->db->resultSet();
        $newdatas=[];
        foreach ($datas as $data) {
            $this->db->query("SELECT * FROM Bewertung WHERE administrativeId= :administrativeId AND projectId= :projectId AND finish=0 LIMIT 1");
            $this->db->bind(":administrativeId", $_SESSION["user_id"]);
            $this->db->bind(":projectId", $data['id']);
            $ans = $this->db->resultSet();
            if (empty($ans))
            {
                $this->db->query("SELECT * FROM Bewertung WHERE administrativeId= :administrativeId AND projectId= :projectId AND finish=1");
                $this->db->bind(":administrativeId", $_SESSION["user_id"]);
                $this->db->bind(":projectId", $data['id']);
                $ans = $this->db->resultSet();
                $this->db->query("SELECT * FROM Kriterien");
                $answer = $this->db->resultSet();
                if (count($ans) == count($answer)){
                    $data['finish'] = 1;
                } else {
                    $data['finish'] = 0;
                }

            } else {
                $data['finish'] = 0;
            }
            array_push($newdatas, $data);
        }
        return $newdatas;
    }

    // Projekt wird als Datensatz in die DB eingetragen
    public function createProject($data, $number )
    {
        $this->db->query("INSERT INTO Project
        (`userid`, `title`, `text`, `pictureIncrement`)
        VALUES (:userid, :title, :text, :pictureIncrement)");
        $this->db->bind(":userid", $data['userid']);
        $this->db->bind(":title", $data['title']);
        $this->db->bind(":text", $data['text']);
		$this->db->bind(":pictureIncrement", $number);
        $answer = $this->db->execute();

        // get Id from DB
        $this->db->query("SELECT id FROM Project ORDER BY ID DESC LIMIT 1");
        $id = $this->db->resultSet();

        // set Id on Model
        $this->setId($id[0]['id']);

        return $answer;
    }

	public function checkProjectOnPerson(int $userId)
	{
		$this->db->query("SELECT * FROM Project WHERE userId = :userId");
		$this->db->bind(":userId", $userId);
		$answer = $this->db->resultSet();
		return count($answer);
	}
	// holt pictureIncrement von der DB
	public function getPictureIncrement($id)
	{
		$this->db->query("SELECT pictureIncrement FROM Project WHERE id = :id");
		$this->db->bind(":id", $id);
		$answer = $this->db->resultSet();
		return $answer[0]['pictureIncrement'];
	}

	// setzt pictureIncrement in der DB
	public function setPictureIncrement($id, $number)
	{
		$this->db->query("UPDATE Project SET pictureIncrement = :pictureIncrement WHERE id = :id");
		$this->db->bind(":pictureIncrement", $number);
		$this->db->bind(":id", $id);
		return $this->db->execute();
	}
    // Änderung vom Projekt auf der DB
    public function updateProject($data)
    {
        if ($_SESSION['user_role'] == 'admin') {
            $id = $data["userId"];
        } else {
            $id = $_SESSION['user_id'];
        }
        //Vorbereitung Mysql Eintrag mit überprüfung von id des Projects und entsprechender userId
        $this->db->query("UPDATE Project SET
        title = :title, text = :text
        WHERE id= :id AND userId = :userId");
        $this->db->bind(":title", $data["title"]);
        $this->db->bind(":text", $data["text"]);
        $this->db->bind(":id", $data["id"]);
        $this->db->bind(":userId", $id);

        // Ausführung des eintrags
        $answer = $this->db->execute();

        return $answer;

    }

    // leitet die Projekt-ID an die Löschfunktion weiter
    public function deleteProject($data)
    {
        // Löschprozess mit Projekt-ID initialisieren
        $answer = $this->deletePro($data['id']);
        return $answer;
    }

	public function getAnyProject($id)
	{
		$this->db->query("SELECT * FROM Project WHERE userId = :id");
		$this->db->bind(":id", $id);
		$answer = $this->db->resultSet();
		return $answer;
	}

    // löscht das gesammte Projekt wie auch die hinterlegten Bildpfade von der DB mittels Projekt-ID
    private function deletePro($id)
    {
        $picmodel = new ModelBilder;
        // Aufruf Löschpfad mit entsprechender Projekt-ID
        $picpath = $picmodel->getDeletePath($id);
        if ($picpath !== 0 && explode('/',$picpath)[1] == explode('/',getenv('F_PATH'))[1]) {
            // Löschen des Projektordners auf dem System
            $this->rrmdir($picpath);
        }
        // Überprüfung ob Einträge existieren auf Image von der DB
        $this->db->query("SELECT id
                    FROM Image
                    WHERE projectid = :id");
        $this->db->bind(":id", $id);
        $check = $this->db->resultSet();
        if (isset($check[0])) {
            // Löschen der DB Einträge 'Image' die zum Projekt gehören
            $this->db->query("DELETE FROM Image WHERE projectid = :id");
            $this->db->bind(":id", $id);
            $this->db->execute();
        }
        // Löschen des Projektes selbst (erst möglich wenn alle Einträge unter 'Image' entfernt wurden)
        $this->db->query("DELETE FROM Project  WHERE id = :id");
        $this->db->bind(":id", $id);
        $answer = $this->db->execute();
        return $answer;
    }
    // holt die Projekt-ID von der DB und leitet die Projekt-ID an die Löschfunktion weiter
    public function deleteProjectWithUserId($data)
    {
        // Projekt-ID von DB Holen
        $answer = $this->getProjects($data['userId']);
		$answers =[];
        if ($answer != 0 ){
			foreach ($answer as $project) {
				// Löschprozess mit Projekt-ID initialisieren
				$oneAnswer = $this->deletePro($project['id']);
				array_push($answers, $oneAnswer);
			}
        }
        return $answers;
    }

    // Recursive Löschfunktion eines Ordnerpfades
    private function rrmdir($picpath)
    {
		error_log($picpath);
        if (is_dir($picpath)) {
            $objects = scandir($picpath);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($picpath . DIRECTORY_SEPARATOR . $object) && !is_link($picpath . "/" . $object))
                        $this->rrmdir($picpath . DIRECTORY_SEPARATOR . $object);
                    else
                        unlink($picpath . DIRECTORY_SEPARATOR . $object);
                }
            }
            rmdir($picpath);
        }
    }

    // holt bestimmtes Projekt von der DB
    public function getProject($userId)
    {
        $datas = $this->getAllProject();
        foreach ($datas as $data) {
            if ($data['userId'] == $userId) {
	            return $data;
            }
        }
        return 0;
    }

	public function getProjects($userId)
	{
		$datas = $this->getAllProject();
		$projects= [];
		foreach ($datas as $data) {
			if ($data['userId'] == $userId) {
				array_push($projects, $data);
			}
		}
		return $projects;
	}

    // holt die User-ID von der DB mittels Projekt-ID
    public function getUserIdWithId($projectId)
    {
        $this->db->query("SELECT userId FROM Project WHERE id= :id");
        $this->db->bind(":id", $projectId);
        $data = $this->db->resultSet();
        return $data;
    }

    // check ob Projekt existiert
    public function projectCheck($id)
    {
        $this->db->query("SELECT COUNT(*) FROM Project WHERE id = :id");
        $this->db->bind(":id", $id['projectId']);
        $data = $this->db->resultSet();
        return $data[0]['COUNT(*)'];
    }

    public function approvalProject($id){
        $this->db->query("UPDATE Project SET finish=1 WHERE id= :id");
        $this->db->bind(":id", $id );
        return $this->db->execute();
    }

    /**
     * Checks if a project exists in the Projects Table
     * @param $id int Project ID
     * @return bool true if project exists, false if not
     */
    public function checkProject($id){
        $this->db->query("SELECT COUNT(*) FROM Project WHERE userId = :id");
        $this->db->bind(":id", $id);
        $data = $this->db->resultSet();
        return $data[0]['COUNT(*)'] > 0;
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
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}