<?php

namespace Application\Domain\User;

use Application\Domain\Common\Entity\AbstractEntity;
use Application\Domain\Common\Entity\EntityInterface;
use Application\Domain\Common\ValueObject\EmailAddress;

class User extends AbstractEntity implements EntityInterface
{
    /** @var EmailAddress */
    private $email;

    /** @var string */
    private $password;

    /**
     * @return EmailAddress
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param EmailAddress $email
     * @return $this
     */
    public function setEmail(EmailAddress $email)
    {
        $this->email = $email;
        return $this;
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
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
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