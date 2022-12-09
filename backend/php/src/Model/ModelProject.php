<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
 *
 */


class ModelProject extends ModelBase
{
    private int $userId;
    private string $title;
    private string $text;



    public function fakeWriteData($data)
    {
        $data['id'] = $this->getFakeId();
        //$test = sonderzeichen($data);
        $test = json_encode($data);
        //echo $test;
        return json_decode($test);
    }
    public function createProject($data)
    {
        $this->db->query("INSERT INTO Project
        (`userid`, `title`, `text`)
        VALUES (:userid, :title, :text)");
        $this->db->bind(":userid", $data['userid']);
        $this->db->bind(":title", $data['title']);
        $this->db->bind(":text", $data['text']);
        $answer = $this->db->execute();

        return $answer;
    }

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
        // $test = $this->db->execute();
        // print_r($test);
        return $this->db->execute();

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
    public function getAllProject()
    {
        $this->db->query("SELECT * FROM Project");
        $data = $this->db->resultSet();
        return $data;
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