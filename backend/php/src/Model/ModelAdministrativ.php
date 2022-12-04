<?php
require_once PROJECT_ROOT_PATH . "Model/ModelBase.php";
/**
 *
 */


class ModelAdministrative extends ModelBase
{
    private string $email;
    private string $rolle;
    private int $pwId;
    private int $saltId;

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
     * Get the value of rolle
     */
    public function getRolle()
    {
        return $this->rolle;
    }

    /**
     * Set the value of rolle
     *
     * @return  self
     */
    public function setRolle($rolle)
    {
        $this->rolle = $rolle;

        return $this;
    }


    /**
     * Get the value of saltId
     */
    public function getSaltId()
    {
        return $this->saltId;
    }

    /**
     * Set the value of saltId
     *
     * @return  self
     */
    public function setSaltId($saltId)
    {
        $this->saltId = $saltId;

        return $this;
    }

    /**
     * Get the value of pwId
     */
    public function getPwId()
    {
        return $this->pwId;
    }

    /**
     * Set the value of pwId
     *
     * @return  self
     */
    public function setPwId($pwId)
    {
        $this->pwId = $pwId;

        return $this;
    }
}