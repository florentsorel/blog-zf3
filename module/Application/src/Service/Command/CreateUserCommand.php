<?php

namespace Application\Service\Command;

class CreateUserCommand
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
     * @param array $formData
     * @return CreateUserCommand
     */
    public static function createFromFormData(array $formData)
    {
        $command = new self();
        $command->setEmail($formData['email']);
        $command->setPassword($formData['password']);

        return $command;
    }
}