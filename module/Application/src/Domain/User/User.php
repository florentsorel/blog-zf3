<?php

namespace Application\Domain\User;

use Application\Domain\Common\Entity\AbstractEntity;
use Application\Domain\Common\Entity\EntityInterface;

class User extends AbstractEntity implements EntityInterface
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Permet de vérifier si deux entités ont la même identité
     *
     * @param EntityInterface $candidate
     * @return boolean
     */
    public function sameIdentityAs(EntityInterface $candidate)
    {
        if ( ! $candidate instanceof self) {
            return false;
        }

        return $this->id == $candidate->getId();
    }
}