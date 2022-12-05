<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
 *
 */


class ModelCompetition extends ModelBase
{
    private string $title;
    private string $text;
    private string $teilnehmerbedingungen;

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

    /**
     * Get the value of teilnehmerbedingungen
     */
    public function getTeilnehmerbedingungen()
    {
        return $this->teilnehmerbedingungen;
    }

    /**
     * Set the value of teilnehmerbedingungen
     *
     * @return  self
     */
    public function setTeilnehmerbedingungen($teilnehmerbedingungen)
    {
        $this->teilnehmerbedingungen = $teilnehmerbedingungen;

        return $this;
    }

    public function getfakecompetition()
    {
        $data = ['id' => $this->getFakeId(), 'title' => 'Wettbewerbstitel', 'text' => 'Die von der Frankfurter Brentano-Gesellschaft seit mehr als 20 Jahren herausgegebene Frankfurter Bibliothek ist die größte Lyriksammlung der deutschen Buchhandelsgeschichte. Sie bietet einen Querschnitt durch die Lebenswirklichkeit der Gegenwart – gespiegelt in der in breiten gesellschaftlichen Kreisen gepflegten kleinen Literaturproduktion, die oft unveröffentlicht bleibt und verlorengeht. Über die Präsentation und Bewahrung von Hochliteratur hinaus, soll, der Romantik folgend, aber auch die Lyrik aus der Mitte unseres Volks berücksichtigt werden, die den Alltag und die Gedankenwelt spiegelt und Sozial- und Mentalitätsgeschichte schreibt. In der Frankfurter Bibliothek veröffentlichte Autoren erfüllen übrigens die Zulassungsvoraussetzung zum Fernstudium “Literarisches Schreiben” (Staatliche Zulassung) der Frankfurter Cornelia Goethe Akademie. Mit der Teilnahme am Gedichtwettbewerb geht der Einsender keinerlei Verpflichtungen ein (keine Kosten, keine Buchbestellung, keine Studienanmeldung).', 'teilnehmerbedingung' => '- Mindestens 18 Jahre alt'];

        return $data;
    }

    public function getCompetition()
    {
        $this->db->query("SELECT * FROM Competition");
        $data = $this->db->resultSet();
        return $data[0];
    }

}

?>