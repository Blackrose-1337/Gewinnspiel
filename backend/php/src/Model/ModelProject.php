<?php
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

    // holt alle Projekte von DB
    public function getAllProject()
    {
        $this->db->query("SELECT * FROM Project");
        $data = $this->db->resultSet();
        return $data;
    }

    // Projekt auf der DB hinterlegen
    public function createProject($data)
    {
        $this->db->query("INSERT INTO Project
        (`userid`, `title`, `text`)
        VALUES (:userid, :title, :text)");
        $this->db->bind(":userid", $data['userid']);
        $this->db->bind(":title", $data['title']);
        $this->db->bind(":text", $data['text']);
        $answer = $this->db->execute();

        // get Id from DB
        $this->db->query("SELECT id FROM Project ORDER BY ID DESC LIMIT 1");
        $id = $this->db->resultSet();

        // set Id on Model
        $this->setId($id[0]['id']);

        return $answer;
    }

    // Änderung vom Projekt auf der DB
    public function updateProject($data)
    {
        //Vorbereitung Mysql Eintrag mit überprüfung von id des Projects und entsprechender userId
        $this->db->query("UPDATE Project SET
        title = :title, text = :text
        WHERE id= :id AND userId = :userId");
        $this->db->bind(":title", $data["title"]);
        $this->db->bind(":text", $data["text"]);
        $this->db->bind(":id", $data["id"]);
        $this->db->bind(":userId", $data["userId"]);

        // Ausführung des eintrags
        $answer = $this->db->execute();

        return $answer;

    }

    public function deleteProject($data)
    {
        $picmodel = new ModelBilder;

        $picpath = $picmodel->getDeletePath($data['id']);
        $this->rrmdir($picpath);
        $this->db->query("DELETE FROM Image WHERE projectid = :id");
        $this->db->bind(":id", $data["id"]);
        $this->db->execute();
        $this->db->query("DELETE FROM Project  WHERE id = :id");
        $this->db->bind(":id", $data["id"]);
        $answer = $this->db->execute();
        return $answer;
    }
    public function deleteProjectWithUserId($data)
    {
        $picmodel = new ModelBilder;

        $answer = $this->getProject($data['userId']);
        $picpath = $picmodel->getDeletePath($answer['id']);
        $this->rrmdir($picpath);

        $this->db->query("SELECT id
                        FROM Image
                        WHERE projectid = :id");
        $this->db->bind(":id", $answer['id']);
        $check = $this->db->resultSet();
        if (isset($check[0])) {
            $this->db->query("DELETE FROM Image WHERE projectid = :id");
            $this->db->bind(":id", $answer['id']);
            $this->db->execute();
        }
        $this->db->query("DELETE FROM Project  WHERE id = :id");
        $this->db->bind(":id", $answer['id']);
        $answer = $this->db->execute();
        return $answer;
    }

    private function rrmdir($picpath)
    {
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
        return $datas;
    }

    public function getUserIdWithId($projectId)
    {
        $this->db->query("SELECT userId FROM Project WHERE id= :id");
        $this->db->bind(":id", $projectId);
        $data = $this->db->resultSet();
        return $data;
    }


    // Testfunktionen
    public function fakeWriteData($data)
    {
        $data['id'] = $this->getFakeId();
        $answer = json_encode($data);
        return json_decode($answer);
    }

    public function getFakeProject($userId)
    {
        $datas = $this->getFakeAllProject();
        foreach ($datas as $data) {
            if ($data['userId'] == $userId) {
                return $data;
            }
        }
        return $datas;
    }

    public function getFakeAllProject()
    {
        $datas = [
            ['id' => '0', 'userId' => '3', 'title' => 'Olaaa Chica', 'text' => 'Nicht viel zu sagen die Bilder sprechen für sich.'],
            ['id' => '1', 'userId' => '4', 'title' => 'What??', 'text' => 'COOKIES COOOKIES COOOOOOKIES!!!!'],
            [
                'id' => '2',
                'userId' => '5',
                'title' => 'Moonshine',
                'text' => 'Im en so geblendet ja behaglich ausdenken gewachsen ernsthaft. Angenommen brotkugeln an getunchten vertreiben ab. Zu er
            nachtessen flusterton fluchtigen so so angenommen. Wendete beinahe so bosheit zu spruche schones te in. Ihr sprachen die
            kurioses schuftet erzahlte. Erstaunt brannten hut konntest was streckte wei freilich trostlos. Sei messingnen ordentlich
            wahrhaftig hinstellte als die neidgefuhl. Leuchtete tag verwegene unbemerkt hob tal geburstet.'
            ]
        ];
        return $datas;

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