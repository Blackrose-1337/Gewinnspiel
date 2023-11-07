<?php
// zusätzlicher Aufruf der benötigten Modele zum abruf von Funktionen
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
 *
 */


class ModelCompetition extends ModelBase
{
    private string $title;
    private string $text;
    private string $teilnehmerbedingungen;
	private DateTime $wettbewerbbeginn;
	private DateTime $wettbewerbende;
	private string $wettbewerbCloseText;
	private bool $istEmailAktiv;
	private bool $istProjektLoeschenUserErlaubt;

    // holt alle Wettbewerbsinformationen von DB (alle Datensätze / hat bloss einen )
    public function getCompetition()
    {
        $this->db->query("SELECT * FROM Competition");
        $data = $this->db->resultSet();
        return $data[0];
    }
	public function isMailAllowed()
	{
		$this->db->query("SELECT istEmailAktiv FROM Competition");
		$data = $this->db->resultSet();
		return $data[0]["istEmailAktiv"];
	}
	public function isDeleteAllowed()
	{
		$this->db->query("SELECT istProjektLoeschenUserErlaubt FROM Competition");
		$data = $this->db->resultSet();
		return $data[0]["istProjektLoeschenUserErlaubt"];
	}

    // Passt Wettbewerbsinformation auf der DB an
    public function updateData($data)
    {
        $this->db->query("UPDATE Competition SET
        title = :title, text = :text, teilnehmerbedingung = :teilnehmerbedingung, wettbewerbbeginn = :wettbewerbbeginn, wettbewerbende = :wettbewerbende, wettbewerbCloseText = :wettbewerbCloseText, istEmailAktiv = :istEmailAktiv, istProjektLoeschenUserErlaubt = :istProjektLoeschenUserErlaubt
        WHERE id = :id");
        $this->db->bind(":title", $data["title"]);
        $this->db->bind(":text", $data["text"]);
        $this->db->bind(":teilnehmerbedingung", $data["teilnehmerbedingung"]);
        $this->db->bind(":wettbewerbbeginn", $data["wettbewerbbeginn"]);
        $this->db->bind(":wettbewerbende", $data["wettbewerbende"]);
        $this->db->bind(":wettbewerbCloseText", $data["wettbewerbCloseText"]);
		$this->db->bind(":istEmailAktiv", $data["istEmailAktiv"]);
		$this->db->bind(":istProjektLoeschenUserErlaubt", $data["istProjektLoeschenUserErlaubt"]);
        $this->db->bind(":id", $data["id"]);
        return $this->db->execute();
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
}
?>