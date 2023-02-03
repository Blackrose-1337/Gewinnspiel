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
    private string $pw;
    private string $token;

    /** Beispieluser zum Testen vom Login
     * Mail: poppel@gmx.ch
     * pw: exampel1DDH?
     * Mail: business@gmail.com
     * pw: exampel2DDH?
     * Mail: nanomail@gmail.com
     * pw: exampel3DDH?
     */

    //Create User
    public function createUser($data)
    {
        // initalisieren von Objekten
        $salt = new ModelSalt;
        $modelpw = new ModelPw;

        $this->db->query("SELECT id FROM User WHERE email = :email");
        $this->db->bind(":email", $data["email"]);
        $check = $this->db->resultSet();
        error_log(json_encode($check));
        if (isset($check[0])) {
            return 0;
        } else {


            // salt erstellen und direkt auf der Datenbank speichern
            $salt->createSaltDB();

            // den frisch generierten Salteintrag holen
            $this->db->query("SELECT * FROM Salt ORDER BY ID DESC LIMIT 1");

            // Salteintrag auf Variable festhalten
            $salt = $this->db->resultSet();

            // random genierten String auf Variable setzen
            $pw = $this->getString();

            // Im Model Pw hinterlegen für Mailversand
            $this->setPw($pw);

            // mit generiertem String und Salt ein Hash generieren, welcher direkt auf der Datenbank gespeichert wird.
            $modelpw->generateHashDB($pw, $salt[0]["salt"]);

            // frisch generierten Pweintrag (Hash) nur die Id holen
            $this->db->query("SELECT id FROM Pw ORDER BY ID DESC LIMIT 1");

            // Id eintrag auf Variable festhalten
            $modelpw = $this->db->resultSet();

            $this->setToken($this->rndtoken());

            // Eintragsvorbereitung User in die Datenbank
            $this->db->query("INSERT INTO User
            (`name`, `surname`, `role`, `email`, `land`, `plz`, `ortschaft`, `strasse`, `strNr`, `tel`,`vorwahl`, `pwId`, `saltId`, `token`)
            VALUES (:name, :surname, :role, :email, :land, :plz, :ortschaft, :strasse, :strNr, :tel,:vorwahl, :pwId, :saltId, :token)");
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
            $this->db->bind(":vorwahl", $data["vorwahl"]);
            $this->db->bind(":pwId", $modelpw[0]["id"]);
            $this->db->bind(":saltId", $salt[0]["id"]);
            $this->db->bind(":token", $this->getToken());

            // Ausführung
            $answer = $this->db->execute();

            // get Id from DB
            $this->db->query("SELECT id FROM User ORDER BY ID DESC LIMIT 1");
            $id = $this->db->resultSet();

            // set Id on Model
            $this->id = $id[0]['id'];
            return $answer;
        }
    }

    // Session erstellen und Token für Frontend


    // get all User expect admin
    public function getDataUser()
    {
        // Get-Data from Mysql   id,name,surname,role,email,land,plz,ortschaft,strasse,strNr,tel
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

    // change User values
    public function changeUser($data)
    {
        // Eintragsvorbereitung der Datenanpassung über Id
        $this->db->query("UPDATE User SET
        name = :name, surname = :surname, role = :role, email = :email, land = :land, plz = :plz, ortschaft = :ortschaft, strasse = :strasse, strNr = :strNr, tel = :tel, vorwahl = :vorwahl
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
        $this->db->bind(":vorwahl", $data["vorwahl"]);

        // Ausführung
        return $this->db->execute();
    }

    // Testfunktionen
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

    public function fakewriteData($data)
    {
        $data['id'] = $this->getFakeId();
        $newdata = $this->sonderzeichen($data);
        $newdata = json_encode($newdata);

        return json_decode($newdata);
    }

    public function fakeCreateUser($data)
    {
        echo json_encode($data);
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

    public function getUserinfo($data)
    {
        $this->db->query("SELECT name, surname, email FROM User WHERE id= :id");
        $this->db->bind(":id", $data['userId']);
        $newdata = $this->db->resultSet();
        $data['name'] = $newdata[0]['name'];
        $data['surname'] = $newdata[0]['surname'];
        $data['mail'] = $newdata[0]['email'];
        return $data;
    }

    public function tokencheck($token)
    {
        error_log($token);
        $this->db->query("UPDATE User SET optIn = 1 WHERE token = :token");
        $this->db->bind(":token", $token);
        $answer = $this->db->execute();
        if ($answer == 0) {
            $this->db->query("SELECT COUNT(optIn) FROM User WHERE token = :token");
            $this->db->bind(":token", $token);
            $answer = $this->db->resultSet();
            error_log(json_encode($answer[0]['COUNT(optIn)']));
            error_log('check');
            $newdata[0]['id'] = 0;
            if ($answer[0]['COUNT(optIn)'] == 1) {
                $answer = 2;
                $this->db->query("SELECT name,surname,email FROM User WHERE token = :token");
                $this->db->bind(":token", $token);
                $newdata = $this->db->resultSet();
                $newdata[0]['id'] = 2;
            }
        } elseif ($answer == 1) {
            $this->db->query("SELECT name,surname,email FROM User WHERE token = :token");
            $this->db->bind(":token", $token);
            $newdata = $this->db->resultSet();
            $newdata[0]['id'] = 1;
        }
        return $newdata[0];
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
     * Get the value of pw
     */
    public function getPw()
    {
        return $this->pw;
    }

    /**
     * Set the value of pw
     *
     * @return  self
     */
    public function setPw($pw)
    {
        $this->pw = $pw;

        return $this;
    }


    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}