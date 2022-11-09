<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
require_once PROJECT_ROOT_PATH . "Model/ModelPwSalt.php";
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
    private int $pwSaltId;


    /**
     * TestMethode die einfach einen var_dump macht. Sie ist dazu da die GUI-Funktionaltiäten zu testen
     *
     * 
     *
     * @return $data
     */
    public function fakewriteData($data)
    {
        $test = print_r($data);

        return $test;
    }


    /**
     * TestMethode die einfach nur Fake-Daten liefert, solange man noch keine DB hat
     * private int $textId;
     * @return $data : Liste aus Orders
     */
    public function getFakeDataUser()
    {
        $data = [
            ['id' => $this->getFakeId(), 'name' => 'Peter', 'surname' => 'Laucher', 'role' => 'jury', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => '84669', 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '12', 'pwSaltId' => '32'],
            ['id' => $this->getFakeId(), 'name' => 'Ricarda', 'surname' => 'Murer', 'role' => 'teilnehmende', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => '84669', 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '13', 'pwSaltId' => '33'],
            ['id' => $this->getFakeId(), 'name' => 'Philippe', 'surname' => 'Egger', 'role' => 'teilnehmende', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => '84669', 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '14', 'pwSaltId' => '34'],
            ['id' => $this->getFakeId(), 'name' => 'Joel', 'surname' => 'Packer', 'role' => 'teilnehmende', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => '84669', 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '15', 'pwSaltId' => '35'],
            ['id' => $this->getFakeId(), 'name' => 'Claudia', 'surname' => 'Schlirrer', 'role' => 'jury', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => '84669', 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '16', 'pwSaltId' => '36'],
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
            ['id' => '2', 'name' => 'Peter', 'surname' => 'Laucher', 'email' => 'test1@test.ch', 'land' => 'DE', 'plz' => '84669', 'ortschaft' => 'rostock', 'strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '12', 'pwSaltId' => '32'],
        ];

        return $data;
    }


    /**
     * Hilfsmethode : die eine Liste für die GUI zusammenfipselt
     *
     * @param  mixed $orderArray, Liste aus Orders
     * @param  mixed $menueArray, Liste aus Menues
     *
     * @return $data : Array für GUI
     */
    public function renderOderList4GUI($orderArray, $menueArray)
    {
        // Anstatt Dinge in der GUI kompliziert zu machen, bauen wir hier die Dinge so zusammen wie 
        // wir sie brauchen
        // Diesen Array wollen wir zusammenbauen, dann der GUI übergeben
        // Etwas ungeschickt ist hier, dass die Arrays aus Orders und Menues übergeben werden. Dabei könnte sich eigentlich das Model selbst um die Listen kümmern

        $data = [];
        foreach ($orderArray as $order) {
            $orderrow = [];
            foreach ($order as $key => $value) {

                // für jede Bestellung noch das Menü rausfipseln
                if ($key == 'refmenue') {

                    foreach ($menueArray as $menue) {

                        if ($menue['id'] == $value) {
                            //echo var_dump();
                            $orderrow['menueinfo'] = $menue['title'] . "," . $menue['description'];
                        }
                    }
                }

                // alle anderen Dinge einfach rüberkopieren
                $orderrow[$key] = $value;
            }

            array_push($data, $orderrow);
        }

        return $data;
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