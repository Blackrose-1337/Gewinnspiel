<?php
class Database
{

    private $host;
    private $user;
    private $pass;
    private $dbname;


    private $dbh;
    private $stmt;
    private $error;

    public function __construct()
    {
        $this->host = getenv("DB_HOST");
        $this->user = getenv("DB_USERNAME");
        $this->pass = getenv("DB_PASSWORD");
        $this->dbname = getenv("DB_DATABASE_NAME");
        // Set DSN - Verbindungsstring auf den Server
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ";charset=utf8;";
        $options = array(
                //PDO::ATTR_PERSISTENT => true, // Persistent Connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // ErrorHandling
            PDO::FETCH_OBJ // Wir wollen die Resultate als Objekte, und nicht als Arrays

        );

        // Instanz erstellen
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $ex) {
            $this->error = $ex->getMessage();
            echo "Hier kommen wir vorbei" . $this->error;
            exit();
        }
    }

    // Debug Funktion
    public function debugDumpParams()
    {
        $this->stmt->debugDumpParams();
    }

    // Statement vorbereiten mit Query
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }


    // Bind Values
    public function bind($param, $value, $type = null)
    {
        // Falls der Type nicht mitgegeben wird - überprüfen
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Ausführen der Prep-Statements
    public function execute()
    {
        // Ausführung
        $this->stmt->execute();

        //Überprüfung wurde ein Eintrag/Änderung gemacht?
        $count = $this->stmt->rowCount();
        //error_log($this->stmt->);
        // Wenn der count 0 ergibt, weil nichts gemacht wurde wird false/0 zurückgesendet sonst true/1
        if ($count == 0 ) {
            return 0;
        } else {
            return 1;
        }
    }

    // Das Ergebnis als Array aus Objekten
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    // Das Ergebnis als Einzelnes Objekt
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    // Anzahl der Resultate // RowCount
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

}