<?php
// require_once PROJECT_ROOT_PATH . "Model/Database.php";
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: http://localhost:3000");
header('Content-Type: application/json');
header('Accept: application/json');
 
class UserModel 
{
    public function getUsers()
    {
        $data = [
            ['id' => '2', 'name' => 'Peter', 'surname' => 'Laucher','email' => 'test1@test.ch','land' => 'DE','plz' => '84669','ortschaft' => 'rostock','strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '12', 'pwSaltId'=>'32'],
            ['id' => '3', 'name' => 'Ricarda', 'surname' => 'Murer','email' => 'test1@test.ch','land' => 'DE','plz' => '84669','ortschaft' => 'rostock','strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '13', 'pwSaltId'=>'33'],
            ['id' => '4', 'name' => 'Philippe', 'surname' => 'Egger','email' => 'test1@test.ch','land' => 'DE','plz' => '84669','ortschaft' => 'rostock','strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '14', 'pwSaltId'=>'34'],
            ['id' => '5', 'name' => 'Joel', 'surname' => 'Packer','email' => 'test1@test.ch','land' => 'DE','plz' => '84669','ortschaft' => 'rostock','strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '15', 'pwSaltId'=>'35'],
            ['id' => '6', 'name' => 'Claudia', 'surname' => 'Schlirrer','email' => 'test1@test.ch','land' => 'DE','plz' => '84669','ortschaft' => 'rostock','strasse' => 'Lauerstr.', 'strNr' => '23', 'tel' => '4465155', 'textid' => '16', 'pwSaltId'=>'36'],
        ];
        return $data;
        // return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?", ["i", $limit]);
    }
}