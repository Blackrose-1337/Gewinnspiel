<?php

class ModelPw extends ModelBase
{
    //Attribute
    private string $hash;

    public function resetHashbyId(int $value, int $id)
    {
        //pw search with id would be here

        $pw = $this->getString();
        $hash = $this->mySha512($pw, $value, 10000);
        return $pw;
    }

    private function mySha512($str, $salt, $iterations)
    {
        for ($x = 0; $x < $iterations; $x++) {
            $str = hash('sha512', $str . $salt);
        }
        return $str;
    }


    /**
     * Get the value of hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the value of hash
     *
     * @return  self
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }
}

?>