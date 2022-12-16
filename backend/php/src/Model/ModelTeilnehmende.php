<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
require_once PROJECT_ROOT_PATH . "Model/ModelSalt.php";
require_once PROJECT_ROOT_PATH . "Model/ModelPw.php";
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
     * Mail: poppel@gmx.ch
     * pw: exampel1DDH?
     * Mail: business@gmail.com
     * pw: exampel2DDH?
     * Mail: nanomail@gmail.com
     * pw: exampel3DDH?
     * 
     */


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

    //Create User
    public function createUser($data)
    {
        // initalisieren von Objekten
        $salt = new ModelSalt;
        $modelpw = new ModelPw;

        // salt erstellen und direkt auf der Datenbank speichern
        $salt->createSaltDB();

        // den frisch generierten Salteintrag holen
        $this->db->query("SELECT * FROM Salt ORDER BY ID DESC LIMIT 1");

        // Salteintrag auf Variable festhalten
        $salt = $this->db->resultSet();

        // random genierten String auf Variable setzen
        $pw = $this->getString();

        // mit generiertem String und Salt ein Hash generieren, welcher direkt auf der Datenbank gespeichert wird.
        $modelpw->generateHashDB($pw, $salt[0]["salt"]);

        // frisch generierten Pweintrag (Hash) nur die Id holen
        $this->db->query("SELECT id FROM Pw ORDER BY ID DESC LIMIT 1");

        // Id eintrag auf Variable festhalten
        $modelpw = $this->db->resultSet();

        // Eintragsvorbereitung User in die Datenbank
        $this->db->query("INSERT INTO User
        (`name`, `surname`, `role`, `email`, `land`, `plz`, `ortschaft`, `strasse`, `strNr`, `tel`, `pwId`, `saltId`)
        VALUES (:name, :surname, :role, :email, :land, :plz, :ortschaft, :strasse, :strNr, :tel, :pwId, :saltId)");
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":surname", $data["surname"]);
        $this->db->bind(":role", $data["role"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":land", $data["land"]);
        $this->db->bind(":plz", $data["plz"]);
        $this->db->bind(":ortschaft", $data["ortschaft"]);
        $this->db->bind(":strasse", $data["str"]);
        $this->db->bind(":strNr", $data["strNr"]);
        $this->db->bind(":tel", $data["tel"]);
        $this->db->bind(":pwId", $modelpw[0]["id"]);
        $this->db->bind(":saltId", $salt[0]["id"]);

        // Ausführung
        $answer = $this->db->execute();

        // get Id from DB
        $this->db->query("SELECT id FROM User ORDER BY ID DESC LIMIT 1");
        $id = $this->db->resultSet();

        // set Id on Model
        $this->id = $id[0]['id'];
        return $answer;
    }

    public function login()
    {

    }
    public function createUserSession($id, $email, $name, $role, $token)
    {
        if ($token == '') {
            $token = $this->rndtoken();
        }

        $_SESSION['user_id'] = $id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        $_SESSION['token'] = $token;
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

    // change User values
    public function changeUser($data)
    {
        // Eintragsvorbereitung der Datenanpassung über Id
        $this->db->query("UPDATE User SET
        name = :name, surname = :surname, role = :role, email = :email, land = :land, plz = :plz, ortschaft = :ortschaft, strasse = :strasse, strNr = :strNr, tel = :tel
        WHERE id = :id");
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":surname", $data["surname"]);
        $this->db->bind(":role", $data["role"]);
        $this->db->bind(":email", $data["email"]);
        $this->db->bind(":land", $data["land"]);
        $this->db->bind(":plz", $data["plz"]);
        $this->db->bind(":ortschaft", $data["ortschaft"]);
        $this->db->bind(":strasse", $data["strasse"]);
        $this->db->bind(":strNr", $data["strNr"]);
        $this->db->bind(":tel", $data["tel"]);
        $this->db->bind(":id", $data["id"]);

        // Ausführung
        return $this->db->execute();
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

    // get all User expect admin
    public function getDataUser()
    {
        // Get-Data from Mysql
        $this->db->query("SELECT * FROM User WHERE role !='admin'");
        $data = $this->db->resultSet();
        return $data;
    }
    private function getAllUser()
    {
        // Get-Data from Mysql
        $this->db->query("SELECT * FROM User");
        $data = $this->db->resultSet();
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
    // FAKE Get single User
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
    public function getUserwithMail($userMail)
    {
        $datas = $this->getAllUser();
        foreach ($datas as $data) {
            if ($data['email'] == $userMail) {
                return $data;
            } else {

            }
        }

    }

    // Get single User
    public function getUser($userId)
    {
        $datas = $this->getDataUser();
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

}