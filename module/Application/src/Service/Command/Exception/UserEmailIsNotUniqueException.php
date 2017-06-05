<?php

namespace Application\Service\Command\Exception;

use RuntimeException;

class UserEmailIsNotUniqueException extends RuntimeException
{
    /**
     * @param string $email
     * @return UserEmailIsNotUniqueException
     */
    public static function fromEmail($email)
    {
        return new self(
            "Email address {$email} is already used by another user"
        );
    }
}