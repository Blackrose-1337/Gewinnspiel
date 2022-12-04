<?php

class ModelBewertung extends ModelBase
{
    //Attribute
    private int $administrativeId;
    private int $userId;
 

    public function getFakeKritierien()
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