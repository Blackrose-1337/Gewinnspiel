<?php
// zusätzlicher Aufruf der benötigten Modele zum abruf von Funktionen
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
        // Aufruf benötigter Klassen
        $salt = new ModelSalt;
        $modelpw = new ModelPw;

        // Überprüfung, ob E-Mail bereits existiert
        $this->db->query("SELECT email FROM User WHERE LOWER(email) = LOWER(:email)");
        $this->db->bind(":email", $data["email"]);
        $check = $this->db->resultSet();
        // falls die DB eine Übereinstimmung hat, wird 'false' zurückgegeben
        if (isset($check[0]) && $check[0]["email"] == $data["email"]) {
			return 0;
        } else {


            // salt erstellen und direkt auf der Datenbank speichern
            $salt->createSaltDB();

            // den frisch generierten Salteintrag holen und Salteintrag auf Variable festhalten
            $this->db->query("SELECT * FROM Salt ORDER BY ID DESC LIMIT 1");
            $salt = $this->db->resultSet();

            // random genierten String auf Variable setzen
            $pw = $this->getString();

            // Im Model Pw hinterlegen für Mailversand
            $this->setPw($pw);

            // mit generiertem String und Salt ein Hash generieren, welcher direkt auf der Datenbank gespeichert wird.
            $modelpw->generateHashDB($pw, $salt[0]["salt"]);

            // frisch generierten Pweintrag (Hash) nur die Id holen und auf Variable setzen
            $this->db->query("SELECT id FROM Pw ORDER BY ID DESC LIMIT 1");
            $modelpw = $this->db->resultSet();

            // Im Model Token hinterlegen
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
            $this->db->bind(":strasse", $data["strasse"]);
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

    // alle User von DB holen ausser Admin rollen
    public function getDataUser()
    {
        // Abfrage aller Daten ausser 'role' == admin
        $this->db->query("SELECT * FROM User WHERE role !='admin'");
        $data = $this->db->resultSet();

        return $data;
    }

    // Löschen eines User mittels ID
    public function deleteUser($data)
    {
        // User löschen mittels Id vergleich
        $this->db->query("DELETE FROM User WHERE id = :id");
        $this->db->bind(":id", $data["userId"]);
        $answer = $this->db->execute();
        return $answer;
    }

    // Alle User der DB holen
    private function getAllUser()
    {
        // Alle User der DB holen
        $this->db->query("SELECT * FROM User");
        $data = $this->db->resultSet();
        return $data;
    }

    // User von DB holen mittels Mail
    public function getUserwithMail($userMail)
    {
        // Abruf aller User
        $datas = $this->getAllUser();
        // Vergleich der Mailadresse mit Lowercase (Gross- und Kleinschreibung ignorieren)
        foreach ($datas as $data) {
            if (strtolower($data['email']) == strtolower($userMail)) {
                return $data;
            }
        }
        return 0;
    }

    // Get single User with ID
    public function getUser($userId)
    {
        // Userabruf 
        $datas = $this->getDataUser();
        // Mit foreach-loop id abgleichen
        foreach ($datas as $data) {
            if ($data['id'] == $userId) {
                return $data;
            }
        }
        return $datas;
    }

    // Änderungen von User Daten mittels ID
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

    // User DB informationen abrufen und gezielt bereitstellen
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

    public function getUserRole($id){
        $this->db->query("SELECT role FROM User WHERE id= :id");
        $this->db->bind(":id", $id);
        return $this->db->resultSet();
    }
    public function getPwSaltId($id){
        $this->db->query("SELECT pwId, saltId FROM User WHERE id= :id");
        $this->db->bind(":id", $id);
        return $this->db->resultSet();
    }
    public function getJury()
    {
        $this->db->query("SELECT id, name, surname FROM User WHERE role=jury");
        return $this->db->resultSet();
    }

	// funktion zum setzen des OptIn Status auf der DB
	public function setOptInDB($email){
		$this->db->query("UPDATE User SET optIn = 1 WHERE email = :email");
		$this->db->bind(":email", $email);
		return $this->db->execute();
	}

    // Token überprüfung
    public function tokencheck($token)
    {

        // Versuch optIn zu ändern, wo Tokens übereinstimmen
        $this->db->query("UPDATE User SET optIn = 1 WHERE token = :token");
        $this->db->bind(":token", $token);
        $answer = $this->db->execute();

        // falls der Versuch fehlgeschlagen ist wird nach dem Token auf der DB gesucht
        if ($answer == 0) {
            $this->db->query("SELECT COUNT(optIn) FROM User WHERE token = :token");
            $this->db->bind(":token", $token);
            $answer = $this->db->resultSet();

            // Wert setzen zur beeinflussung, welche Antwort der User erhält
            $newdata[0]['id'] = 0; // Token existiert nicht auf der Datenbank

            // falls ein Token gefunden wurde wird die Antwort überschrieben
            if ($answer[0]['COUNT(optIn)'] == 1) {
                $answer = 2;
                $this->db->query("SELECT name,surname,email FROM User WHERE token = :token");
                $this->db->bind(":token", $token);
                $newdata = $this->db->resultSet();
                $newdata[0]['id'] = 2; // Token existiert und optIn ist bereits positiv
            }

            // falls die optIn Änderung erfolgreich war
        } elseif ($answer == 1) {
            // Userinformationen abrufen für Antwort
            $this->db->query("SELECT name,surname,email FROM User WHERE token = :token");
            $this->db->bind(":token", $token);
            $newdata = $this->db->resultSet();
            $newdata[0]['id'] = 1; // erfolgreiche Bestätigung und optIn wurde gesetzt
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