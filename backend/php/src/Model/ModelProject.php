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
    public function getFakeProject($userId)
    {
        $datas = [
            ['id' => '0', 'userId' => '3', 'title' => 'Olaaa Chica', 'text' => 'Nicht viel zu sagen die Bilder sprechen für sich.'],
            ['id' => '1', 'userId' => '4', 'title' => 'What??', 'text' => 'COOKIES COOOKIES COOOOOOKIES!!!!'],
            [
                'id' => '1',
                'userId' => '5',
                'title' => 'Moonshine',
                'text' => 'Im en so geblendet ja behaglich ausdenken gewachsen ernsthaft. Angenommen brotkugeln an getunchten vertreiben ab. Zu er
            nachtessen flusterton fluchtigen so so angenommen. Wendete beinahe so bosheit zu spruche schones te in. Ihr sprachen die
            kurioses schuftet erzahlte. Erstaunt brannten hut konntest was streckte wei freilich trostlos. Sei messingnen ordentlich
            wahrhaftig hinstellte als die neidgefuhl. Leuchtete tag verwegene unbemerkt hob tal geburstet.'
            ]
        ];
        foreach ($datas as $data) {
            if ($data['userId'] == $userId) {
                return $data;
            }
        }
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