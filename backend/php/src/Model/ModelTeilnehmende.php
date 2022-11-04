<?php

/**
* Definition der Order-Attribute
* id -> ID der Bestellung
* userid -> Referenz auf den User (zukünftig)
* username -> Benutzername
* email -> Email des Benutzers
* comment -> Kommentar
* refmenue -> Referenz auf das bestellte Menü
* status -> ein int. 0 => "Bestellt", 1 => "Abholbereit", 2 => "Abgeholt"
* dateorder -> Datum und Zeitpunkt der Bestellung
*/


class ModelTeilnehmende extends ModelBase
{
    // Alle Attribute des Models
    private string $name;
    private string $surname;
    private string $email;
    private string $land;
    private int $plz;
    private string $ortschaft;
    private string $strasse;
    private int $strNr;
    private int $tel;
    private int $textId;
    private int $pwSaltId;

    
    /**
     * TestMethode die einfach einen var_dump macht. Sie ist dazu da die GUI-Funktionaltiäten zu testen
     *
     * @param  mixed $data
     *
     * @return void
     */
    public function fakewriteData($data)
    {
        die(var_dump($data));
        
    }

    
    /**
     * TestMethode die einfach nur Fake-Daten liefert, solange man noch keine DB hat
     *
     * @return $data : Liste aus Orders
     */
    public function getFakeOrderData()
    {
        $data = [
            ['id' => '2', 'userid' => '', 'username' => 'TestBenutzer1','email' => 'test1@test.ch','comment' => 'TestKommentar1','refmenue' => '1','status' => '0','dateorder' => ''],
            ['id' => '3', 'userid' => '', 'username' => 'TestBenutzer2','email' => 'test2@test.ch','comment' => 'TestKommentar2','refmenue' => '2','status' => '1','dateorder' => ''],
            ['id' => '4', 'userid' => '', 'username' => 'TestBenutzer3','email' => 'test3@test.ch','comment' => 'TestKommentar3','refmenue' => '1','status' => '2','dateorder' => ''],
            ['id' => '5', 'userid' => '', 'username' => 'TestBenutzer4','email' => 'test4@test.ch','comment' => 'TestKommentar4','refmenue' => '3','status' => '0','dateorder' => '']
        ];

        return $data;
    }

    /**
     * TestMethode die einfach nur Fake-Daten liefert, solange man noch keine DB hat
     *
     * @param  mixed $userid
     *
     * @return $data : Liste aus Orders
     */
    public function getFakeOrderDataForUserID($userid)
    {
        $data = [
            ['id' => '2', 'userid' => '1','username' => 'TestBenutzer1','email' => 'test1@test.ch','comment' => 'TestKommentar1','refmenue' => '1','status' => '1','dateorder' => '']
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
        foreach($orderArray as $order)
        {
            $orderrow = [];
            foreach ($order as $key => $value) {

                // für jede Bestellung noch das Menü rausfipseln
                if ($key == 'refmenue')
                {
                    
                    foreach($menueArray as $menue){
                        
                        if ($menue['id'] == $value)
                        {
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
     * Get the value of textId
     */ 
    public function getTextId()
    {
        return $this->textId;
    }

    /**
     * Set the value of textId
     *
     * @return  self
     */ 
    public function setTextId($textId)
    {
        $this->textId = $textId;

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
