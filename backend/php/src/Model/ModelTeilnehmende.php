<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
 *
 */


class ModelTeilnehmende extends ModelBase
{
    // Alle Attribute des Models
    private string $name;
    private string $surname;
    private string $role;
    private string $email;
    private string $land;
    private int $plz;
    private string $ortschaft;
    private string $strasse;
    private int $strNr;
    private int $tel;
    private int $pwId;
    private int $saltId;


    /**
     * TestMethode die einfach einen var_dump macht. Sie ist dazu da die GUI-Funktionaltiäten zu testen
     *
     * 
     *
     * @return $data
     */
    public function fakewriteData($data)
    {
        // preg_match($muster, $testtext)   Muster erkennung möglichkeit   $muster= "/1[0123456789]/"       $testtext= "Wir haben 13 Katzen"  !!!REGEX!!!   regexlip.com/DisplayPatterns.aspx

        // input validation  www.owasp.org/index.php/Input_Validation_Cheat_Sheet#Input_validation-strategies

        $data['id'] = $this->getFakeId();
        $test = $this->sonderzeichen($data);

        $test = json_encode($test);
        //echo $test;
        return json_decode($test);
    }
    public function fakeCreateUser($data)
    {
        echo json_encode($data);
    }

    public function fakeChangeUser($data)
    {
        // get user by id
        echo $this->name = $data['name'];
        echo $this->surname = $data['surname'];
        echo $this->email = $data['email'];
        echo $this->role = $data['role'];
        echo $this->land = $data['land'];
        echo $this->plz = $data['plz'];
        echo $this->ortschaft = $data['ortschaft'];
        echo $this->strasse = $data['strasse'];
        echo $this->strNr = $data['strNr'];
        echo $this->tel = $data['tel'];

    }

    /**
     * TestMethode die einfach nur Fake-Daten liefert, solange man noch keine DB hat
     * private int $textId;
     * @return $data : Liste aus Orders
     */
    public function getFakeDataUser()
    {
        $data = [
            ['id' => 2, 'name' => 'Peter', 'surname' => 'Laucher', 'role' => 'jury', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => 84669, 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => 23, 'tel' => 4465155, 'textid' => 12, 'pwId' => 32, 'saltId' => 20],
            ['id' => 3, 'name' => 'Ricarda', 'surname' => 'Murer', 'role' => 'teilnehmende', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => 84669, 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => 12, 'tel' => 4465155, 'textid' => 13, 'pwId' => 12, 'saltId' => 2],
            ['id' => 4, 'name' => 'Philippe', 'surname' => 'Egger', 'role' => 'teilnehmende', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => 84669, 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => 3, 'tel' => 4465155, 'textid' => 14, 'pwId' => 2, 'saltId' => 12],
            ['id' => 5, 'name' => 'Joel', 'surname' => 'Packer', 'role' => 'teilnehmende', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => 84669, 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => 213, 'tel' => 4465155, 'textid' => 15, 'pwId' => 3, 'saltId' => 3],
            ['id' => 6, 'name' => 'Claudia', 'surname' => 'Schlirrer', 'role' => 'jury', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => 84669, 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => 200, 'tel' => 4465155, 'textid' => 16, 'pwId' => 7, 'saltId' => 4],
        ];
        return $data;
    }

    /**
     * TestMethode die einfach nur Fake-Daten liefert, solange man noch keine DB hat
     * private int $textId;
     *
     * @return $data : Liste aus Orders
     */
    public function getFakeOrderDataForUserID($userid)
    {
        $data = [
            ['id' => '2', 'name' => 'Peter', 'surname' => 'Laucher', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => '84669', 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '12', 'pwId' => '32', 'saltId' => '20'],
        ];

        return $data;
    }
    public function getFakeUser($userId)
    {
        $datas = $this->getFakeDataUser();
        foreach ($datas as $data) {
            if ($data['id'] == $userId) {
                return $data;
            }
        }
        return $datas;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set the value of surname
     *
     * @return  self
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of land
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * Set the value of land
     *
     * @return  self
     */
    public function setLand($land)
    {
        $this->land = $land;

        return $this;
    }

    /**
     * Get the value of plz
     */
    public function getPlz()
    {
        return $this->plz;
    }

    /**
     * Set the value of plz
     *
     * @return  self
     */
    public function setPlz($plz)
    {
        $this->plz = $plz;

        return $this;
    }

    /**
     * Get the value of ortschaft
     */
    public function getOrtschaft()
    {
        return $this->ortschaft;
    }

    /**
     * Set the value of ortschaft
     *
     * @return  self
     */
    public function setOrtschaft($ortschaft)
    {
        $this->ortschaft = $ortschaft;

        return $this;
    }


    /**
     * Get the value of strasse
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

    /**
     * Set the value of strasse
     *
     * @return  self
     */
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;

        return $this;
    }

    /**
     * Get the value of strNr
     */
    public function getStrNr()
    {
        return $this->strNr;
    }

    /**
     * Set the value of strNr
     *
     * @return  self
     */
    public function setStrNr($strNr)
    {
        $this->strNr = $strNr;

        return $this;
    }

    /**
     * Get the value of tel
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set the value of tel
     *
     * @return  self
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get the value of pwSaltId
     */
    public function getPwSaltId()
    {
        return $this->pwSaltId;
    }

    /**
     * Set the value of pwSaltId
     *
     * @return  self
     */
    public function setPwSaltId($pwSaltId)
    {
        $this->pwSaltId = $pwSaltId;

        return $this;
    }
}